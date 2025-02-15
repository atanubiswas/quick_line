<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaseStudyController extends Controller
{
    private $pageName = "Case Study";
    public function viewCaseStudy(){
        $pageName = $this->pageName;
        return view('admin.viewCaseStudy', compact('pageName'));
    }
}
