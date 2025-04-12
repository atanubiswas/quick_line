<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;


use App\Models\study;
use App\Models\Doctor;
use App\Models\patient;
use App\Models\caseStudy;
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
    public function viewCaseStudy(Request $request){
        $start_date = $end_date = Carbon::now()->startOfDay();
        $end_date = Carbon::now()->endOfDay();;
        $pageName = $this->pageName;
        $centre_id = 0;
        $centre_name = "";

        if(in_array(auth()->user()->roles[0]->id, [1, 5, 6])){
            $CaseStudies = caseStudy::orderBy('created_at', 'desc')
                ->with('assigner', 'patient', 'laboratory', 'doctor', 'status', 'modality.DoctorModality.Doctor')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();
        }
        elseif(in_array(auth()->user()->roles[0]->id, [4])){
            $doctor = Doctor::where("user_id", auth()->user()->id)->first();
            $CaseStudies = caseStudy::orderBy('created_at', 'desc')
                ->with('assigner', 'patient', 'laboratory', 'doctor', 'status', 'modality.DoctorModality.Doctor')
                ->whereIn('study_status_id', [2, 4])
                ->where("doctor_id", $doctor->id)
                ->get();
        }
        elseif(in_array(auth()->user()->roles[0]->id, [2])){
            $doctor = Doctor::where("user_id", auth()->user()->id)->first();
            $CaseStudies = caseStudy::orderBy('created_at', 'desc')
                ->with('assigner', 'patient', 'laboratory', 'doctor', 'status', 'modality.DoctorModality.Doctor')
                ->whereIn('study_status_id', [3])
                ->get();
        }
        elseif(in_array(auth()->user()->roles[0]->id, [3])){
            $centre = Laboratory::where("user_id", auth()->user()->id)->first();
            $centre_id = $centre->id;
            $centre_name = $centre->lab_name;
            $CaseStudies = caseStudy::orderBy('created_at', 'desc')
                ->with('assigner', 'patient', 'laboratory', 'doctor', 'status', 'modality.DoctorModality.Doctor')
                ->where('laboratory_id', $centre->id)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();
        }
        else{
            $CaseStudies = array();
        }

        $authUser = Auth::user();
        $authUserId = $authUser->id;
        $roleId = $authUser->roles[0]->pivot->role_id;
        
        $Labrotories = Laboratory::where("status", 1)
            ->orderBy("lab_name")
            ->get();
        return view('admin.viewCaseStudy', compact('pageName', 'CaseStudies', 'Labrotories', 'roleId', 'centre_id', 'centre_name'));
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
                'age'=> 'required',
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
            $addedBy = Auth::user()->id;
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
            $caseStudy->added_by = $addedBy;
            $caseStudy->save();

            foreach($request->study_id as $key=>$studyId){
                $study = new Study();
                $study->case_study_id = $caseStudy->id;
                $study->study_type_id = $studyId;
                $study->description = $request->description[$key];
                $study->save();
            }

            if($request->hasFile('images')){
                $oldUmask = umask(0002);
                foreach($request->file('images') as $image){
                    $imageName = time().'_'.str_replace(" ", "_", $image->getClientOriginalName());
                    $relativePath = 'uploads/' . str_replace(" ", "_", $labName) . '/' . str_replace(" ", "_", $request->patient_name);
                    $directoryPath = storage_path('app/public/' . $relativePath);

                    // Manually create directory with correct permissions
                    if (!File::exists($directoryPath)) {
                        File::makeDirectory($directoryPath, 0755, true);
                    }

                    $fullPath = $relativePath . '/' . $imageName;
                    
                    Storage::putFileAs('public/' . $relativePath, $image, $imageName);
                    umask($oldUmask); 

                    $studyImage = new studyImages;
                    $studyImage->case_study_id = $caseStudy->id;
                    $studyImage->image = $fullPath;
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

    /**
     * Summary of getAllStudies
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getAllStudies(Request $request){
        $allStudies = array();
        try{
            $caseStudy = caseStudy::where("id", $request->case_id)->with('doctor')->first();
            
            $caseId = $request->case_id;
            $lab_id = $caseStudy->laboratory_id;

            $caseDetails = caseStudy::find($caseId);
            $authUser = Auth::user();
            $roleId = Auth::user()->roles[0]->pivot->role_id;

            if($caseStudy->study_status_id == 1 && $roleId != 3){
                $caseStudy->assigner_id = $authUser->id;
                $caseStudy->save();
            }
            else if($caseStudy->study_status_id == 3){
                if(Auth::user()->roles[0]->pivot->role_id == 2){
                    $caseStudy->qc_id = Auth::user()->id;
                    $caseStudy->save();
                }
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
            
            $authUser = Auth::user();
            $roleId = Auth::user()->roles[0]->pivot->role_id;
            return view('admin.getAllStudies', compact( 'caseId','allStudies', 'doctors', 'caseStudy', 'assignedDoctor', 'faveriteDoctors', 'roleId'));
        }catch (\Exception $e){
            $allStudies['error'] = $e->getMessage();
            return view('admin.getAllStudies', compact('allStudies'));
        }
        catch(\Illuminate\Database\QueryException $ex){
            $allStudies['error'] = $e->getMessage();
            return view('admin.getAllStudies', compact('allStudies'));
        }
    }

    public function resetAssignerId(Request $request){
        $study = caseStudy::find($request->case_id);
        if($study->study_status_id == 1 && $study->assigner_id == Auth::user()->id){
            $study->assigner_id = null;
            $study->save();
        }
        else if($study->study_status_id == 3 && $study->qc_id == Auth::user()->id){
            $study->qc_id = null;
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

    public function getCaseStudySearchResult(Request $request){
        $start_date = Carbon::parse($request->start_date)->startOfDay();;
        $end_date = Carbon::parse($request->end_date)->endOfDay();;
        $centre_id = empty($request->centre_id)?null:$request->centre_id;

        $authUser = Auth::user();
        $roleId = Auth::user()->roles[0]->pivot->role_id;
        $centre_id = Laboratory::where("user_id", $authUser->id)->first()->id;
        
        $CaseStudies = caseStudy::orderBy('created_at', 'desc')
        ->with('assigner', 'patient', 'laboratory', 'doctor', 'status', 'modality.DoctorModality.Doctor')
        ->whereBetween('created_at', [$start_date, $end_date])
        ->when($centre_id !== null, function($query) use($centre_id){
            $query->where("laboratory_id", $centre_id);
        })
        ->when($roleId == 3, function($query) use($centre_id){
            $query->where("laboratory_id", $centre_id);
        })
        ->get();
        
        $authUserId = Auth::user()->id;

        return view('admin.caseStudySearchResult', compact( 'CaseStudies', 'authUserId'));
    }

    public function getCaseStudyImages(Request $request){
        $caseStudy = caseStudy::with("modality", "study.type", "images")
            ->where("id", $request->case_study_id)
            ->first();
        $authUser = Auth::user();
        $roleId = Auth::user()->roles[0]->pivot->role_id;
        
        if($roleId == 2 && $caseStudy->study_status_id == 3){
            $caseStudy->qc_id = Auth::user()->id;
            $caseStudy->save();
        }

        return view('admin.doctorCaseImageView', compact( 'caseStudy', 'authUser', 'roleId'));
    }
}
