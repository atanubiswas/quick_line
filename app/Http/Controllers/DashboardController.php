<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Traits\GeneralFunctionTrait;
use App\Models\User;
use App\Models\caseStudy;

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
            // case 'Assigner':
            //     return $this->assignerDashboard();
            case 'Quality Controller':
                return $this->qualityControllerDashboard();
            default:
                return view ("admin.dashboard");
        }
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
        // Get assigner counts for today by default
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
        $doctorCounts = User::whereHas('roles', function($q){
            $q->where('name', 'Doctor');
        })
        ->withCount(['doctorCaseStudies' => function($q) use ($today) {
            $q->whereDate('case_studies.created_at', $today);
        }])
        ->orderBy('name', 'asc')
        ->get()
        ->map(function($user){
            return (object)[
                'name' => $user->name,
                'count' => $user->doctor_case_studies_count
            ];
        });
        return view ("admin.adminDashboard", compact('totalCaseThisMonth', 'topCentreThisMonth', 'topQCThisMonth', 'topDoctorThisMonth', 'assignerCounts', 'qcCounts', 'doctorCounts'));
    }

    /**
     * Summary of doctorDashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function doctorDashboard(){
        $totalCaseThisMonth = $this->getTotalCaseThisMonth();
        $currentActiveCase = $this->getCurrentActiveCase();
        $currentEmergencyCase = $this->getCurrentActiveCase(true);
        $currentReworkCase = $this->getCurrentReWorkCase();
        $caseStudyList = $this->getCaseStudyList();
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfDay()->toDateString();
        
        return view ("admin.doctorDashboard", compact('totalCaseThisMonth', 'currentActiveCase', 'currentEmergencyCase', 'currentReworkCase', 'caseStudyList', 'startDate', 'endDate'));
    }

    private function qualityControllerDashboard(){
        $totalCaseThisMonth = $this->getTotalCaseThisMonth();
        $currentActiveCase = $this->getCurrentActiveCase();
        $currentEmergencyCase = $this->getCurrentActiveCase(true);
        $caseStudyList = $this->getCaseStudyList();
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfDay()->toDateString();

        return view ("admin.qualityControllerDashboard", compact('totalCaseThisMonth', 'currentActiveCase', 'currentEmergencyCase', 'caseStudyList', 'startDate', 'endDate'));
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
        $doctors = User::whereHas('roles', function($q){
            $q->where('name', 'Doctor');
        })
        ->withCount(['doctorCaseStudies' => function($q) use ($start, $end) {
            $q->whereDate('case_studies.created_at', '>=', $start)
              ->whereDate('case_studies.created_at', '<=', $end);
        }])
        ->orderBy('name', 'asc')
        ->get()
        ->map(function($user){
            return [
                'name' => $user->name,
                'count' => $user->doctor_case_studies_count
            ];
        });
        return response()->json($doctors);
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
}
