<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;


use App\Models\study;
use App\Models\Doctor;
use App\Models\patient;
use App\Models\CaseStudy;
use App\Models\studyType;
use App\Models\Laboratory;
use App\Models\studyImages;


use App\Traits\GeneralFunctionTrait;

class CaseStudyController extends Controller
{
    use GeneralFunctionTrait;
    private $pageName = "Case Study";

    /**
     * Summary of viewCaseStudy
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewCaseStudy(){
        $pageName = $this->pageName;
        $CaseStudies = CaseStudy::orderBy('created_at', 'desc')
        ->with('assigner', 'patient', 'laboratory', 'doctor', 'status', 'modality.DoctorModality.Doctor')
        ->get();
        //dd($CaseStudies[0]->modality->DoctorModality);
        $authUserId = Auth::user()->id;
        $Labrotories = Laboratory::where("status", 1)
            ->orderBy("lab_name")
            ->get();
        return view('admin.viewCaseStudy', compact('pageName', 'CaseStudies', 'Labrotories', 'authUserId'));
    }

    /**
     * Summary of getStudyType
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getStudyType(Request $request){
        $studyTypes = studyType::where("modality_id", $request->modality_id)->orderBy("name")->get();
        return view('admin.getStudyTypes', compact('studyTypes'));
    }

    public function insertCaseStudy(Request $request){
        DB::beginTransaction();
        try{
            $validationArray = [
                'centre_id' => 'required|exists:laboratories,id',
                'modality' => 'required|exists:modalities,id',
                'patient_id' => 'required_if:existing_patient,1|nullable|string|exists:patients,patient_id',
                'patient_name' => 'required',
                'age'=> 'required|numeric',
                'gender' => 'required',
                'study_id' => 'required|array',
                'study_id.*' => 'required|exists:study_types,id',
                'clinical_history' => 'required'
            ];
            $customMessages = [
                'patient_id.required_if' => 'The Patient ID is required when Existing Patient is selected.',
                'study_id.*.required' => 'All the Study Type fields are required.',
            ];
            $validator = Validator::make($request->all(), $validationArray, $customMessages);
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()]);
            }

            $lab = Laboratory::find($request->centre_id);
            $labName = $lab->lab_name;
            if(isset( $request->patient_id) && $request->patient_id !== null){$patientId = $request->patient_id;}
            else{$patientId = $this->generatePatientId();}
            
            $patient = Patient::updateOrCreate(
                ['patient_id' => $patientId],
                [
                    'name' => $request->patient_name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'clinical_history' => $request->clinical_history,
                ]
            );
            $caseStudy = new CaseStudy();
            $caseStudy->laboratory_id = $request->centre_id;
            $caseStudy->patient_id = $patient->id;
            $caseStudy->clinical_history = $request->clinical_history;
            $caseStudy->is_emergency = $request->emergency===null?0:1;
            $caseStudy->is_post_operative = $request->post_operative===null?0:1;
            $caseStudy->is_follow_up = $request->follow_up===null?0:1;
            $caseStudy->is_subspecialty = $request->subspecialty===null?0:1;
            $caseStudy->is_callback = $request->callback===null?0:1;
            $caseStudy->study_status_id = 1;
            $caseStudy->status_updated_on = Carbon::now();
            $caseStudy->case_study_id = $this->generateCaseStudyId();
            $caseStudy->modality_id = $request->modality;
            $caseStudy->save();

            foreach($request->study_id as $key=>$studyId){
                $study = new Study();
                $study->case_study_id = $caseStudy->id;
                $study->study_type_id = $studyId;
                $study->description = $request->description[$key];
                $study->save();
            }

            if($request->hasFile('images')){
                foreach($request->file('images') as $image){
                    $imageName = time().'_'.$image->getClientOriginalName();
                    $storagePath = storage_path('app'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$labName.DIRECTORY_SEPARATOR.$request->patient_name);
                    $image->move($storagePath, $imageName);
                    $studyImage = new studyImages;
                    $studyImage->study_id = $study->id;
                    $studyImage->image = $storagePath.DIRECTORY_SEPARATOR.$imageName;
                    $studyImage->save();
                }
            }
            DB::commit();
        }catch(\Exception $ex) {
            DB::rollback();
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }

    public function getPatientDetails(Request $request){
        try{
            $patient = patient::where("patient_id", $request->patient_id)->first();
            return response()->json(['status'=>'success', 'patient'=>$patient]);
        }catch (\Exception $e){
            return response()->json(['status'=>'error', 'message'=>$e->getMessage()]);
        }
    }

    public function getAllStudies(Request $request){
        $allStudies = array();
        // try{
            $caseStudy = caseStudy::where("id", $request->case_id)->with('doctor')->first();
            
            $caseId = $request->case_id;
            $lab_id = $caseStudy->laboratory_id;

            $caseDetails = caseStudy::find($caseId);

            if($caseStudy->study_status_id == 1){
                $caseStudy->assigner_id = Auth::user()->id;
                $caseStudy->save();
            }

            $allStudies = study::where("case_study_id", $request->case_id)
                ->with('type.modality')
                ->get();
            $doctors = Doctor::whereHas('modalities', function ($query) {
                    $query->where('modality_id', 1);
                })
                ->orderBy('name', 'asc')
                ->whereNotIn("id", function($query) use ($lab_id){
                    $query->select('doctor_id')->from('lab_black_listed_doctors')->where('laboratorie_id', $lab_id)->where("status", 1);
                })
                ->get();
            $assignedDoctor = Doctor::whereIn("id", function($query) use($caseDetails){
                    $query->select('doctor_id')->from('lab_preferred_doctors')
                        ->where('modality_id', $caseDetails->modality_id)
                        ->where('laboratorie_id', $caseDetails->laboratory_id);
                })
                ->first();

            $faveriteDoctors = Doctor::selectRaw("doctors.id, doctors.name, count(case_studies.id) as count")
                ->rightJoin('case_studies', 'doctors.id', '=', 'case_studies.doctor_id')
                ->where('modality_id', $caseDetails->modality_id)
                ->where('laboratory_id', $caseDetails->laboratory_id)
                ->where('study_status_id', 5)
                ->groupBy('doctors.id', 'doctors.name')
                ->orderBy('count', 'desc')
                ->take(5)
                ->get();
                
            return view('admin.getAllStudies', compact( 'caseId','allStudies', 'doctors', 'caseStudy', 'assignedDoctor', 'faveriteDoctors'));
        // }catch (\Exception $e){
        //     $allStudies['error'] = $e->getMessage();
        //     return view('admin.getAllStudies', compact('allStudies'));
        // }
        // catch(\Illuminate\Database\QueryException $ex){
        //     $allStudies['error'] = $e->getMessage();
        //     return view('admin.getAllStudies', compact('allStudies'));
        // }
    }

    public function resetAssignerId(Request $request){
        $study = caseStudy::find($request->case_id);
        if($study->study_status_id == 1 && $study->assigner_id == Auth::user()->id){
            $study->assigner_id = null;
            $study->save();
        }
    }

    public function assignDoctor(Request $request){
        $caseId = $request->case_id;
        $doctorId = $request->doctor_id;
        $study = caseStudy::find($caseId);
        $study->doctor_id = $doctorId;
        $study->study_status_id = 2;
        $study->status_updated_on = Carbon::now();
        $study->save();
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }
}
