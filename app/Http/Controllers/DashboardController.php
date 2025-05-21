<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\GeneralFunctionTrait;

class DashboardController extends Controller
{
    use GeneralFunctionTrait;
    public function dashboard(){
        $roleName = auth()->user()->roles[0]->name;
        switch ($roleName) {
            case 'Admin':
                return $this->adminDashboard();
            // case 'Manager':
            //     return $this->managerDashboard();
            // case 'Doctor':
            //     return $this->doctorDashboard();
            // case 'Laboratory':
            //     return $this->laboratoryDashboard();
            // case 'Assigner':
            //     return $this->assignerDashboard();
            // case 'Quality Controller':
            //     return $this->qualityControllerDashboard();
            default:
                return view ("admin.dashboard");
        }
    }

    private function adminDashboard(){
        $totalCaseThisMonth = $this->getTotalCaseThisMonth();
        $topCentreThisMonth = $this->getTopCentreThisMonth();
        $topQCThisMonth = $this->getTopQCThisMonth();
        $topDoctorThisMonth = $this->getTopDoctorThisMonth();
        return view ("admin.adminDashboard", compact('totalCaseThisMonth', 'topCentreThisMonth', 'topQCThisMonth', 'topDoctorThisMonth'));
    }
}
