<?php

namespace App\Http\Controllers;

use App\Models\studyStatus;
use App\Models\studyType;
use App\Traits\GeneralFunctionTrait;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\modalityStudyLayout;
use App\Models\caseStudy;
use App\Models\Modality;
use App\Models\study;
use App\Models\Doctor;

class StudyLayoutController extends Controller
{
    use GeneralFunctionTrait;
    private $pageName = "Study Layout";
    
    private function updateMainCaseStudyDoc($caseStudyId, $status){
        $caseStudy = caseStudy::find($caseStudyId);
        $pendingCaseCount = study::where("case_study_id", $caseStudyId)
            ->where("status", 0)
            ->count();

        if($pendingCaseCount == 0){
            $caseStudy->study_status_id = $status;
            if($status != 3){
                $authUser = Auth::user();
                $caseStudy->qc_id = $authUser->id;
            }
            
            $caseStudy->save();
            if($status == 3){
                $msg = $this->generateLoggedMessage("saveCaseStudy", "Case Study");
                $this->addLog('case_study', 'case_study_id', $caseStudy->id, 'update', $msg);
            }
            else{
                $studyStatus = studyStatus::find($status);
                $msg = $this->generateLoggedMessage("saveCaseStudyQC", "Case Study", $studyStatus->name);
                $this->addLog('case_study', 'case_study_id', $caseStudy->id, 'update', $msg);
            }
        }
    }

    /**
     * Summary of addStudyLayout
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addStudyLayout(){
        $modalityes = Modality::all();
        $doctors = Doctor::orderBy("name")->get();
        return view("admin.addStudyLayout", ["modalityes" => $modalityes, "pageName" => $this->pageName, "doctors" => $doctors]);
    }

    /**
     * Summary of insertStudyLayout
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function insertStudyLayout(Request $request){
        $validator = Validator::make($request->all(), [
            "layout_name" => "required",
            "study_id" => "required:exists:studies,id",
            "modality" => "required:exists:modalities,id",
            "doctor_id" => "required",
            "layout" => "required",
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        try{
            $studyLayout = new modalityStudyLayout();
            $studyLayout->name  = $request->layout_name;
            $studyLayout->study_type_id  = $request->study_id;
            $studyLayout->layout = $request->layout;
            if($request->doctor_id != 0){
                $studyLayout->created_by = $request->doctor_id;
            }
            $studyLayout->save();
        }catch(\Exception $ex) {
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        } catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }

    /**
     * Summary of viewStudyLayout
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewStudyLayout(){
        $pageName = $this->pageName;
        $modalityes = Modality::all();
            
        return view('admin.viewStudyLayout', compact('pageName', 'modalityes'));
    }

    /**
     * Summary of viewStudies
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewStudies(){
        $pageName = "Studies";
        $modalityes = Modality::all();
        return view('admin.viewStudies', compact('pageName', 'modalityes'));
    }

    /**
     * Summary of getStudyDetails
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getStudyDetails(Request $request){
        $studies = studyType::where('modality_id', $request->modality)->orderBy("name", 'ASC')->get();
        return view('admin.studyDetails', compact('studies'));
    }

    public function insertNewCaseStudy(Request $request){
        $validator = Validator::make($request->all(), [
            "study_name" => "required",
            "modality_id" => "required|exists:modalities,id",
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        try{
            $studyType = new studyType();
            $studyType->name  = $request->study_name;
            $studyType->modality_id = $request->modality_id;
            $studyType->save();
        }catch(\Exception $ex) {
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        } catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }

    public function getStudyLayout(Request $request){
        $studyTypes = studyType::where("modality_id", $request->modality)
            ->orderBy("name")
            ->get();
        return view('admin.getStudyLayout', compact('studyTypes'));
    }

    public function getStudyLayoutTable(Request $request){
        $studyLayouts = modalityStudyLayout::where("study_type_id", $request->study)
            ->orderBy('id', 'desc')
            ->with('studyType', 'doctor')
            ->get();
            
        return view('admin.getStudyLayoutTable', compact('studyLayouts'));
    }

    public function getLayouts(Request $request){
        if($request->layout_id == 0){
            $study = study::where("id", $request->study_id)
                ->first();
            return $study->report;
        }
        $layout = modalityStudyLayout::where("id", $request->layout_id)
            ->first();
            
        return $layout->layout;
    }

    public function saveCaseSingleStudy(Request $request){
        $validator = Validator::make($request->all(), [
            "study_id" => "required:exists:studies,id",
            "qc_status" => "sometimes|nullable",
            "layout" =>  ['required', function ($attribute, $value, $fail) {
                // Strip tags and whitespace
                if (trim(strip_tags($value)) === '') {
                    $fail('The ' . $attribute . ' field is required.');
                }
            }],
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        try{
            $study = study::find($request->study_id);
            $oldLayout = $study->report;
            $study->report = $request->layout;
            $study->status = 1;
            $study->save();
            
            $caseStudyStatus = 3;
            $caseStudy = caseStudy::find($study->case_study_id);
            
            if($caseStudy->study_status_id == 3){
                $caseStudyStatus = $request->qc_status;
            }

            if(empty($oldLayout) || (!empty($request->qc_status) && $oldLayout == $request->layout)){
                $msg = $this->generateLoggedMessage("saveStudy", "Study ".$study->type->name);
                $this->addLog('case_study', 'case_study_id', $caseStudy->id, 'statusChange', $msg);
            }
            else{
                $msg = $this->generateLoggedMessage("updateStudy", "Study ".$study->type->name, "", "", $oldLayout, $request->layout);
                $this->addLog('case_study', 'case_study_id', $caseStudy->id, 'update', $msg);
            }
            $this->updateMainCaseStudyDoc($study->case_study_id, $caseStudyStatus);
        }catch(\Exception $ex) {
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        } catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }
}
