<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Traits\GeneralFunctionTrait;

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
        return view ("admin.adminDashboard", compact('totalCaseThisMonth', 'topCentreThisMonth', 'topQCThisMonth', 'topDoctorThisMonth'));
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
}
