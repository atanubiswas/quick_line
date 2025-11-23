<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

use App\Traits\GeneralFunctionTrait;
use App\Models\User;
use App\Models\caseStudy;
use App\Models\StudyPriceGroup;
use App\Models\Doctor;
use App\Models\study;
use App\Models\studyType;

/**
 * Summary of DashboardController
 */
class DashboardController extends Controller
{
    use GeneralFunctionTrait;

    /**
     * Summary of dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function dashboard(){
        $roleName = auth()->user()->roles[0]->name;
        switch ($roleName) {
            case 'Admin':
                return $this->adminDashboard();
            case 'Manager':
                return $this->adminDashboard();
            case 'Doctor':
                return $this->doctorDashboard();
            // case 'Laboratory':
            //     return $this->laboratoryDashboard();
            case 'Assigner':
                return $this->assignerDashboard();
            case 'Quality Controller':
                return $this->qualityControllerDashboard();
            default:
                return view ("admin.dashboard");
        }
    }

    /**
     * Summary of assignerDashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function assignerDashboard(){
        $totalCaseThisMonth = $this->getTotalCaseThisMonth();
        $todayCaseCount = $this->getTodayCaseCount();
        $activeCaseCount = $this->getCurrentActiveCase();
        $currentEmergencyCase = $this->getCurrentActiveCase(true);
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfDay()->toDateString();
        
        return view ("admin.assignerDashboard", compact('totalCaseThisMonth', 'todayCaseCount', 'activeCaseCount', 'currentEmergencyCase', 'startDate', 'endDate'));
    }

    /**
     * Summary of adminDashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function adminDashboard(){
        $totalCaseThisMonth = $this->getTotalCaseThisMonth();
        $topCentreThisMonth = $this->getTopCentreThisMonth();
        $topQCThisMonth = $this->getTopQCThisMonth();
        $topDoctorThisMonth = $this->getTopDoctorThisMonth();
        $today = Carbon::now()->toDateString();
        $assignerCounts = User::whereHas('roles', function($q){
            $q->where('name', 'Assigner');
        })
        ->withCount(['assignedCaseStudies' => function($q) use ($today) {
            $q->whereDate('created_at', $today);
        }])
        ->orderBy('name', 'asc')
        ->get()
        ->map(function($user){
            return (object)[
                'name' => $user->name,
                'count' => $user->assigned_case_studies_count
            ];
        });
        $qcCounts = User::whereHas('roles', function($q){
            $q->where('name', 'Quality Controller');
        })
        ->withCount(['qcCaseStudies' => function($q) use ($today) {
            $q->whereDate('created_at', $today);
        }])
        ->orderBy('name', 'asc')
        ->get()
        ->map(function($user){
            return (object)[
                'name' => $user->name,
                'count' => $user->qc_case_studies_count
            ];
        });
        // Get all study price groups
        $studyPriceGroups = StudyPriceGroup::orderBy('id')->pluck('name')->toArray();
        // Get all doctors
        $doctors = User::whereHas('roles', function($q){
            $q->where('name', 'Doctor');
        })->orderBy('name', 'asc')->get();
        // For each doctor, count cases per price group
        $doctorCounts = $doctors->map(function($user) use ($today, $studyPriceGroups) {
            $caseStudies = $user->doctorCaseStudies()
                ->whereDate('case_studies.created_at', $today)
                ->where('case_studies.study_status_id', 5)
                ->whereNull('case_studies.deleted_at')
                ->get();
            $groupCounts = array_fill_keys($studyPriceGroups, 0);
            foreach ($caseStudies as $caseStudy) {
                foreach ($caseStudy->study as $study) {
                    if ($study->type && $study->type->priceGroup) {
                        $groupName = $study->type->priceGroup->name;
                        if (isset($groupCounts[$groupName])) {
                            $groupCounts[$groupName]++;
                        }
                    }
                }
            }
            return [
                'name' => $user->name,
                'groups' => $groupCounts
            ];
        });
        return view ("admin.adminDashboard", compact('totalCaseThisMonth', 'topCentreThisMonth', 'topQCThisMonth', 'topDoctorThisMonth', 'assignerCounts', 'qcCounts', 'doctorCounts', 'studyPriceGroups'));
    }

    /**
     * Summary of doctorDashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function doctorDashboard(){
        $totalCaseThisMonth = $this->getTotalCaseThisMonthDoctor();
        $currentActiveCase = $this->getCurrentActiveCase();
        $currentEmergencyCase = $this->getCurrentActiveCase(true);
        $currentReworkCase = $this->getCurrentReWorkCase();
        $caseStudyList = $this->getCaseStudyList();
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfDay()->toDateString();
        
        return view ("admin.doctorDashboard", compact('totalCaseThisMonth', 'currentActiveCase', 'currentEmergencyCase', 'currentReworkCase', 'caseStudyList', 'startDate', 'endDate'));
    }

    private function qualityControllerDashboard(){
        $totalCaseThisMonth = $this->getTotalCaseThisMonthDoctor();
        $todayCaseCount = $this->getTodayCaseCount();
        $currentActiveCase = $this->getCurrentActiveCase();
        $currentEmergencyCase = $this->getCurrentActiveCase(true);
        $caseStudyList = $this->getCaseStudyList();
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfDay()->toDateString();

        return view ("admin.qualityControllerDashboard", compact('totalCaseThisMonth', 'todayCaseCount', 'currentActiveCase', 'currentEmergencyCase', 'caseStudyList', 'startDate', 'endDate'));
    }

    // AJAX endpoint for assigner counts by date range
    public function assignerCounts(Request $request) {
        $start = $request->input('start_date', Carbon::now()->toDateString());
        $end = $request->input('end_date', Carbon::now()->toDateString());
        $assigners = User::whereHas('roles', function($q){
            $q->where('name', 'Assigner');
        })
        ->withCount(['assignedCaseStudies' => function($q) use ($start, $end) {
            $q->whereDate('created_at', '>=', $start)
              ->whereDate('created_at', '<=', $end);
        }])
        ->orderBy('name', 'asc')
        ->get()
        ->map(function($user){
            return [
                'name' => $user->name,
                'count' => $user->assigned_case_studies_count
            ];
        });
        return response()->json($assigners);
    }

    // AJAX endpoint for QC counts by date range
    public function qcCounts(Request $request) {
        $start = $request->input('start_date', Carbon::now()->toDateString());
        $end = $request->input('end_date', Carbon::now()->toDateString());
        $qcs = User::whereHas('roles', function($q){
            $q->where('name', 'Quality Controller');
        })
        ->withCount(['qcCaseStudies' => function($q) use ($start, $end) {
            $q->whereDate('created_at', '>=', $start)
              ->whereDate('created_at', '<=', $end);
        }])
        ->orderBy('name', 'asc')
        ->get()
        ->map(function($user){
            return [
                'name' => $user->name,
                'count' => $user->qc_case_studies_count
            ];
        });
        return response()->json($qcs);
    }

    // AJAX endpoint for Doctor counts by date range
    public function doctorCounts(Request $request) {
        $start = $request->input('start_date', Carbon::now()->toDateString());
        $end = $request->input('end_date', Carbon::now()->toDateString());
        $studyPriceGroups = StudyPriceGroup::orderBy('id')->pluck('name')->toArray();
        $doctors = User::whereHas('roles', function($q){
            $q->where('name', 'Doctor');
        })->orderBy('name', 'asc')->get();
        $doctorCounts = $doctors->map(function($user) use ($start, $end, $studyPriceGroups) {
            $caseStudies = $user->doctorCaseStudies()
                ->whereDate('case_studies.created_at', '>=', $start)
                ->whereDate('case_studies.created_at', '<=', $end)
                ->where('case_studies.study_status_id', 5)
                ->whereNull('case_studies.deleted_at')
                ->get();
            $groupCounts = array_fill_keys($studyPriceGroups, 0);
            foreach ($caseStudies as $caseStudy) {
                foreach ($caseStudy->study as $study) {
                    if ($study->type && $study->type->priceGroup) {
                        $groupName = $study->type->priceGroup->name;
                        if (isset($groupCounts[$groupName])) {
                            $groupCounts[$groupName]++;
                        }
                    }
                }
            }
            return [
                'name' => $user->name,
                'groups' => $groupCounts
            ];
        });
        return response()->json($doctorCounts);
    }

    // AJAX endpoint for assigner daily counts by date range (for line chart)
    public function assignerDailyCounts(Request $request) {
        $start = $request->input('start_date', Carbon::now()->toDateString());
        $end = $request->input('end_date', Carbon::now()->toDateString());
        $assigners = User::whereHas('roles', function($q){
            $q->where('name', 'Assigner');
        })->orderBy('name', 'asc')->get();

        $dates = collect();
        $period = Carbon::parse($start)->daysUntil(Carbon::parse($end)->addDay());
        foreach ($period as $date) {
            $dates->push($date->toDateString());
        }

        $result = [];
        foreach ($assigners as $assigner) {
            $counts = [];
            foreach ($dates as $date) {
                $count = $assigner->assignedCaseStudies()->whereDate('created_at', $date)->count();
                $counts[] = $count;
            }
            $result[] = [
                'name' => $assigner->name,
                'data' => $counts
            ];
        }
        return response()->json([
            'dates' => $dates,
            'series' => $result
        ]);
    }
    // AJAX endpoint for QC daily counts by date range (for line chart)
    public function qcDailyCounts(Request $request) {
        $start = $request->input('start_date', Carbon::now()->toDateString());
        $end = $request->input('end_date', Carbon::now()->toDateString());
        $qcs = User::whereHas('roles', function($q){
            $q->where('name', 'Quality Controller');
        })->orderBy('name', 'asc')->get();

        $dates = collect();
        $period = Carbon::parse($start)->daysUntil(Carbon::parse($end)->addDay());
        foreach ($period as $date) {
            $dates->push($date->toDateString());
        }

        $result = [];
        foreach ($qcs as $qc) {
            $counts = [];
            foreach ($dates as $date) {
                $count = $qc->qcCaseStudies()->whereDate('created_at', $date)->count();
                $counts[] = $count;
            }
            $result[] = [
                'name' => $qc->name,
                'data' => $counts
            ];
        }
        return response()->json([
            'dates' => $dates,
            'series' => $result
        ]);
    }
    // AJAX endpoint for Doctor daily counts by date range (for line chart)
    public function doctorDailyCounts(Request $request) {
        $start = $request->input('start_date', Carbon::now()->toDateString());
        $end = $request->input('end_date', Carbon::now()->toDateString());
        $doctors = User::whereHas('roles', function($q){
            $q->where('name', 'Doctor');
        })->orderBy('name', 'asc')->get();

        $dates = collect();
        $period = Carbon::parse($start)->daysUntil(Carbon::parse($end)->addDay());
        foreach ($period as $date) {
            $dates->push($date->toDateString());
        }

        $result = [];
        foreach ($doctors as $doctor) {
            $counts = [];
            foreach ($dates as $date) {
                $count = $doctor->doctorCaseStudies()->whereDate('case_studies.created_at', $date)->count();
                $counts[] = $count;
            }
            $result[] = [
                'name' => $doctor->name,
                'data' => $counts
            ];
        }
        return response()->json([
            'dates' => $dates,
            'series' => $result
        ]);
    }

    /**
     * Download Daily Report PDF
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function downloadDailyReport(Request $request) {
        $startDate = $request->input('start_date', Carbon::now()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        
        $authUser = auth()->user();
        $roleNames = $authUser->roles->pluck('name')->toArray();
        
        $assignerData = [];
        $qcData = [];
        $doctorData = [];
        
        // Fetch data based on user role
        if (in_array('Assigner', $roleNames)) {
            $assignerData = $this->getAssignerDataByModality($authUser, $startDate, $endDate);
        } elseif (in_array('Quality Controller', $roleNames)) {
            $qcData = $this->getQCDataByModality($authUser, $startDate, $endDate);
        } elseif (in_array('Doctor', $roleNames)) {
            $doctorData = $this->getDoctorDataByModality($authUser, $startDate, $endDate);
        }
        
        // Create PDF
        $pdf = Pdf::loadView('admin.dailyReportPdf', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'authUser' => $authUser,
            'assignerData' => $assignerData,
            'qcData' => $qcData,
            'doctorData' => $doctorData,
            'userRole' => count($roleNames) > 0 ? $roleNames[0] : 'User'
        ]);

        $filename = 'daily_report_' . $startDate . '_to_' . $endDate . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Get Assigner data by modality
     */
    private function getAssignerDataByModality($user, $startDate, $endDate) {
        $caseStudies = caseStudy::where('assigner_id', $user->id)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->whereNull('deleted_at')
            ->get();

        $modalityData = [];
        foreach ($caseStudies as $caseStudy) {
            $modalityName = $caseStudy->modality->name;
            if (!isset($modalityData[$modalityName])) {
                $modalityData[$modalityName] = 0;
            }
            $modalityData[$modalityName]++;
        }
        return $modalityData;
    }

    /**
     * Get Quality Controller data by modality
     */
    private function getQCDataByModality($user, $startDate, $endDate) {
        $caseStudies = caseStudy::where('qc_id', $user->id)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->whereNull('deleted_at')
            ->get();

        $modalityData = [];
        foreach ($caseStudies as $caseStudy) {
            $modalityName = $caseStudy->modality->name;
            if (!isset($modalityData[$modalityName])) {
                $modalityData[$modalityName] = 0;
            }
            $modalityData[$modalityName]++;
        }
        return $modalityData;
    }

    /**
     * Get Doctor data by modality
     */
    private function getDoctorDataByModality($user, $startDate, $endDate) {
        $caseStudies = $user->doctorCaseStudies()
            ->whereDate('case_studies.created_at', '>=', $startDate)
            ->whereDate('case_studies.created_at', '<=', $endDate)
            ->where('case_studies.study_status_id', 5)
            ->whereNull('case_studies.deleted_at')
            ->get();

        $modalityData = [];
        foreach ($caseStudies as $caseStudy) {
            foreach ($caseStudy->study as $study) {
                if ($study->modality) {
                    $modalityName = $study->modality->modality_name;
                    if (!isset($modalityData[$modalityName])) {
                        $modalityData[$modalityName] = 0;
                    }
                    $modalityData[$modalityName]++;
                }
            }
        }
        return $modalityData;
    }
}
