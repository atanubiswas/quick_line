<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\GeneralFunctionTrait;

class DashboardController extends Controller
{
    use GeneralFunctionTrait;
    public function dashboard(){
        return view ("admin.dashboard");
    }
}
