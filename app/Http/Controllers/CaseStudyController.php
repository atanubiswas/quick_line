<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use ZipArchive;
use Validator;
use Auth;
use Str;
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
        $start_date = !isset($request->sdt)?Carbon::now()->startOfDay():Carbon::parse($request->sdt)->startOfDay();
        $end_date = !isset($request->edt)?Carbon::now()->endOfDay():Carbon::parse($request->edt)->endOfDay();
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
        return view('admin.viewCaseStudy', compact('pageName', 'CaseStudies', 'Labrotories', 'roleId', 'centre_id', 'centre_name', 'authUserId'));
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
                'clinical_history' => 'required',
                'ref_by' => 'nullable|sometimes|string',
            ];
            $customMessages = [
                'patient_id.required_if' => 'The Patient ID is required when Existing Patient is selected.',
                'study_id.*.required' => 'All the Study Type fields are required.',
            ];
            $validator = Validator::make($request->all(), $validationArray, $customMessages);
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()]);
            }
            
            if(!$request->hasFile('images')){
                return response()->json(['error'=>[$this->getMessages('_IMERROR')]]);
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
            $isEmergency = $request->emergency===null?false:true;
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
            $caseStudy->ref_by = $request->ref_by;
            $caseStudy->save();

            $studyTypeArray = array();
            foreach($request->study_id as $key=>$studyId){
                $study = new Study();
                $study->case_study_id = $caseStudy->id;
                $study->study_type_id = $studyId;
                $study->description = $request->description[$key];
                $study->save();
                $studyTypeArray[] =$study->type->name;
            }

            if($request->hasFile('images')){
                $oldUmask = umask(0002);
                foreach($request->file('images') as $image){
                    $imageName = time().'_'.str_replace(" ", "_", $image->getClientOriginalName());
                    $relativePath = 'uploads'.DIRECTORY_SEPARATOR . str_replace(" ", "_", $labName) . DIRECTORY_SEPARATOR . str_replace(" ", "_", $request->patient_name);
                    $directoryPath = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR. $relativePath);
                    
                    // Manually create directory with correct permissions
                    if (!File::exists($directoryPath)) {
                        File::makeDirectory($directoryPath, 0755, true);
                    }

                    $fullPath = $relativePath . DIRECTORY_SEPARATOR . $imageName;
                    
                    Storage::putFileAs('public'.DIRECTORY_SEPARATOR. $relativePath, $image, $imageName);
                    umask($oldUmask); 

                    $studyImage = new studyImages;
                    $studyImage->case_study_id = $caseStudy->id;
                    $studyImage->image = $fullPath;
                    $studyImage->save();
                }
            }

            $msg = $this->generateLoggedMessage("addCaseStudy", 'Case Study', "", "", "", "", $labName, $patient->name, $studyTypeArray, $isEmergency);
            $this->addLog('case_study', 'case_study_id', $caseStudy->id, 'add', $msg);
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
            $msg = $this->generateLoggedMessage("view", 'Case Study');
            $this->addLog('case_study', 'case_study_id', $caseDetails->id, 'view', $msg);
            return view('admin.getAllStudies', compact( 'caseId','allStudies', 'doctors', 'caseStudy', 'assignedDoctor', 'faveriteDoctors', 'roleId'));
        }catch (\Exception $e){
            return $this->getMessages('_GNERROR');
        }
        catch(\Illuminate\Database\QueryException $ex){
            return $this->getMessages('_DBERROR');
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
        $doctor = Doctor::find($doctorId);

        $study = caseStudy::find($caseId);
        $study->doctor_id = $doctorId;
        $study->study_status_id = 2;
        $study->status_updated_on = Carbon::now();
        $study->save();
        $msg = $this->generateLoggedMessage("assignDoctor", 'Case Study', "Dr. ".$doctor->name);
        $this->addLog('case_study', 'case_study_id', $study->id, 'statusChange', $msg);
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }

    public function getCaseStudySearchResult(Request $request){
        $start_date = Carbon::parse($request->start_date)->startOfDay();;
        $end_date = Carbon::parse($request->end_date)->endOfDay();

        $authUser = Auth::user();
        $roleId = Auth::user()->roles[0]->pivot->role_id;

        $centre_id = null;
        if(empty($request->centre_id)){
            $centre_id = Laboratory::where("user_id", $authUser->id)->first();
            if($centre_id){
                $centre_id = $centre_id->id;
            }
        }
        else{
            $centre_id = $request->centre_id;
        }
        
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
        $msg = $this->generateLoggedMessage("view", 'Case Study');
        $this->addLog('case_study', 'case_study_id', $caseStudy->id, 'view', $msg);

        if($request->type=='doc'){
            return view('admin.doctorCaseImageView', compact( 'caseStudy', 'authUser', 'roleId'));
        }
        if($request->type=='assigner'){
            $studyTypes = studyType::where("modality_id", $caseStudy->modality_id)->orderBy("name")->get();
            return view('admin.assignerCaseImageView', compact( 'caseStudy', 'authUser', 'roleId', 'studyTypes'));
        }
    }

    public function caseStudyReport(Request $request){
        $caseStudy = caseStudy::with("modality", "study.type", "images", "patient", "laboratory", "doctor.doctorFormFieldValue")
            ->where("id", $request->case_study_id)
            ->first();
    
        $doctorQualification = $caseStudy->doctor->doctorFormFieldValue->where("form_field_id", "9")->first();
        $registrationNumber = $caseStudy->doctor->doctorFormFieldValue->where("form_field_id", "11")->first();
    
        $studyNames = "";
        foreach($caseStudy->study as $study){
            $studyNames .= $study->type->name . ", ";
        }
        $studyNames = rtrim($studyNames, ", ");
    
        $top = isset($caseStudy->laboratory->labFormFieldValue->where("form_field_id", 12)->first()->value) 
            ? $caseStudy->laboratory->labFormFieldValue->where("form_field_id", 12)->first()->value."mm" 
            : "30mm";
        $right = isset($caseStudy->laboratory->labFormFieldValue->where("form_field_id", 13)->first()->value) 
            ? $caseStudy->laboratory->labFormFieldValue->where("form_field_id", 13)->first()->value."mm" 
            : "30mm";
        $bottom = isset($caseStudy->laboratory->labFormFieldValue->where("form_field_id", 14)->first()->value) 
            ? $caseStudy->laboratory->labFormFieldValue->where("form_field_id", 14)->first()->value."mm" 
            : "30mm";
        $left = isset($caseStudy->laboratory->labFormFieldValue->where("form_field_id", 15)->first()->value) 
            ? $caseStudy->laboratory->labFormFieldValue->where("form_field_id", 15)->first()->value."mm" 
            : "30mm";
        
        // Define filename and save to storage
        $fileName = 'case-study-report-' . $caseStudy->case_study_id . '-'. str_replace(" ", "-", $caseStudy->patient->name).'.pdf';
        $filePath = 'pdfs'.DIRECTORY_SEPARATOR. $fileName;
        // Get the public URL
        $pdfPublicUrl = asset("storage".DIRECTORY_SEPARATOR."{$filePath}");
        
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&color=02013c&data={$pdfPublicUrl}";
        $qrImage = Http::withoutVerifying()->get($qrUrl)->body();
        $qrFilename = $caseStudy->case_study_id . '.png';
        $qrPath = 'qr-codes'.DIRECTORY_SEPARATOR. $qrFilename;
        Storage::disk('public')->put($qrPath, $qrImage);
        $qrLocalPath = public_path('storage'.DIRECTORY_SEPARATOR. $qrPath);
        
        // Create PDF from the same view
        $isPdf = true;
        $pdf = Pdf::loadView('admin.caseStudyReport', compact(
            'caseStudy', 'doctorQualification', 'registrationNumber', 'top', 'right', 'bottom', 'left', 'studyNames', 'pdfPublicUrl', 'isPdf', 'qrLocalPath'
        ))
        ->setPaper('A4', 'portrait');
        // ->setOptions([
        //     'isHtml5ParserEnabled' => true,
        //     'isRemoteEnabled' => true,
        //     'defaultFont' => 'sans-serif',
        //     'margin_top' => (int) $top,      // margin values in mm or points
        //     'margin_right' => (int) $right,
        //     'margin_bottom' => (int) $bottom,
        //     'margin_left' => (int) $left,
        // ]);
        Storage::disk('public')->put($filePath, $pdf->output());
        $isPdf = false;
    
        return view('admin.caseStudyReport', compact(
            'caseStudy', 'doctorQualification', 'registrationNumber', 'top', 'right', 'bottom', 'left', 'studyNames', 'pdfPublicUrl', 'isPdf', 'qrLocalPath'
        ));
    }

    public function generatePdf($case_study_id) {
        $caseStudy = caseStudy::with("modality", "study.type", "images", "patient", "laboratory")
            ->where("case_study_id", $case_study_id)
            ->first();
    
        $doctorQualification = $caseStudy->doctor->doctorFormFieldValue->where("form_field_id", "9")->first();
        $registrationNumber = $caseStudy->doctor->doctorFormFieldValue->where("form_field_id", "11")->first();
        $studyNames = "";
        $signature = public_path('storage' . DIRECTORY_SEPARATOR . $caseStudy->doctor->signature);
        $signature = str_replace("\\", '/', $signature);
    
        foreach ($caseStudy->study as $study) {
            $studyNames .= $study->type->name . ", ";
        }
        $studyNames = rtrim($studyNames, ", ");
    
        $qrData = urlencode(url('case-study/pdf/' . $caseStudy->case_study_id));
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&color=02013c&data={$qrData}";
        $qrImage = Http::withoutVerifying()->get($qrUrl)->body();
        $qrFilename = $caseStudy->case_study_id . '.png';
        $qrPath = 'qr-codes/' . $qrFilename;
        Storage::disk('public')->put($qrPath, $qrImage);
        $qrLocalPath = public_path('storage/' . $qrPath);
    
        $top = optional($caseStudy->laboratory->labFormFieldValue->where("form_field_id", 12)->first())->value ?? "30";
        $right = optional($caseStudy->laboratory->labFormFieldValue->where("form_field_id", 13)->first())->value ?? "30";
        $bottom = optional($caseStudy->laboratory->labFormFieldValue->where("form_field_id", 14)->first())->value ?? "30";
        $left = optional($caseStudy->laboratory->labFormFieldValue->where("form_field_id", 15)->first())->value ?? "30";
    
        $pdf = Pdf::loadView('admin.generatePDF', compact(
            'caseStudy', 'doctorQualification', 'registrationNumber',
            'studyNames', 'qrLocalPath', 'signature',
            'top', 'right', 'bottom', 'left'
        ));
        $pdf->setPaper('A4', 'portrait');
    
        // Save the PDF
        $pdfFilename = str_replace(" ", "-", $caseStudy->patient->patient_id."_".$caseStudy->patient->name) . '-' . time() . '.pdf';
        $pdfPath = 'pdfs/' . $pdfFilename;
        Storage::disk('public')->put($pdfPath, $pdf->output());
    
        // Clean up QR code
        Storage::disk('public')->delete($qrPath);
    
        // Return the public URL
        $pdfUrl = asset('storage/' . $pdfPath);
        return $pdfUrl;
    }

    public function deleteCaseStudy(Request $request){
        $caseStudy = CaseStudy::find($request->case_study_id);
        try{
            if($caseStudy){
                if(!in_array($caseStudy->study_status_id, [1,2])){
                    return response()->json(['status'=>'error', 'message'=> 'You can\'t delete This Case Study Now, Status has Changed.'], 200);
                }
                $caseStudy->study_status_id = 6;
                $caseStudy->status_updated_on = Carbon::now();
                $caseStudy->save();
                
                $caseStudy->delete();
                $msg = $this->generateLoggedMessage("delete", 'Case Study');
                $this->addLog('case_study', 'case_study_id', $caseStudy->id, 'delete', $msg);
                return response()->json(['status'=>'success', 'message' => [$this->getMessages('_DELSUMSG')]]);
            }
            else{
                return response()->json(['status'=>'error', 'message'=>[$this->getMessages('_GNERROR')]]);
            }
        }catch (\Exception $e){
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
    }

    public function deleteExistingStudy(Request $request){
        $caseStudy = caseStudy::find($request->case_study_id);
        if(count($caseStudy->study) == 1){
            return response()->json(['status'=>'error', 'message'=>['You can\'t delete this Study, at least one study is required.']]);
        }
        if($caseStudy->study_status_id > 2){
            return response()->json(['status'=>'error', 'message'=>['You can\'t delete this Study, Status has Changed.']]);
        }

        $study = study::find($request->study_id);
        try{
            if($study){
                $study->delete();
                $msg = $this->generateLoggedMessage("delete", 'Study');
                $this->addLog('study', 'id', $study->id, 'delete', $msg);
                return response()->json(['status'=>'success', 'message' => [$this->getMessages('_DELSUMSG')]]);
            }
            else{
                return response()->json(['status'=>'error', 'message'=>[$this->getMessages('_GNERROR')]]);
            }
        }catch (\Exception $e){
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
    }

    public function addMoreStudy(Request $request){
        $caseStudy = caseStudy::find($request->case_study_id);
        if($caseStudy->study_status_id > 2){
            return response()->json(['status'=>'error', 'message'=>['You can\'t delete this Study, Status has Changed.']]);
        }
        $studyCount = study::where("case_study_id", $request->case_study_id)->where("study_type_id", $request->study_type_id)->count();
        
        if($studyCount > 0){
            return response()->json(['status'=>'error', 'message'=>['This Study Type is already added.']]);
        }
        $study = new study();
        $study->case_study_id = $request->case_study_id;
        $study->study_type_id = $request->study_type_id;
        $study->description = $request->description;
        $study->save();

        $studyTypes = studyType::where("modality_id", $caseStudy->modality_id)->get();
        $msg = $this->generateLoggedMessage("addMoreStudy", 'Study Type', $study->type->name);
        $this->addLog('case_study', 'case_study_id', $caseStudy->id, 'add', $msg);
        $allStudies = study::where("case_study_id", $request->case_study_id)
            ->orderBy("id", "asc")
            ->get();
            
        return view('admin.assignerStudies', compact('allStudies', 'studyTypes'));
    }

    public function updateExistingStudy(Request $request){
        $caseStudy = caseStudy::find($request->case_study_id);
        if($caseStudy->study_status_id > 2){
            return response()->json(['status'=>'error', 'message'=>['You can\'t update this Study, Status has Changed.']]);
        }

        $study = study::find($request->study_id);
        
        $studyCount = study::where("study_type_id", $request->study_type_id)
            ->where("case_study_id", $request->case_study_id)
            ->count();
        if($studyCount > 0 && $study->study_type_id != $request->study_type_id){
            return response()->json(['status'=>'error', 'message'=>['This Study Type is already added.']]);
        }
        $oldStudyName = $study->type->name;

        $study->study_type_id = $request->study_type_id;
        $study->description = $request->description;
        $study->save();
        $study->refresh();
        
        if($oldStudyName != $study->type->name){
            $msg = $this->generateLoggedMessage("updateExistingStudy", 'Study Type', '', '', $oldStudyName, $study->type->name);
            $this->addLog('case_study', 'case_study_id', $caseStudy->id, 'update', $msg);
        }
        return response()->json(['status'=>'success', 'message' => [$this->getMessages('_UPSUMSG')]]);
    }

    public function updateCaseStudy(Request $request){
        $validationArray = [
            'patient_name' => 'required',
            'age'=> 'required',
            'gender' => 'required',
            'clinical_history' => 'required',
            'ref_by' => 'nullable|sometimes|string',
        ];
        $customMessages = [
            'patient_id.required_if' => 'The Patient ID is required when Existing Patient is selected.',
            'study_id.*.required' => 'All the Study Type fields are required.',
        ];
        $validator = Validator::make($request->all(), $validationArray, $customMessages);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }

        $caseStudy = caseStudy::find($request->case_study_id);
        if($caseStudy->study_status_id > 2){
            return response()->json(['status'=>'error', 'message'=>['You can\'t update this Study, Status has Changed.']]);
        }
        $caseStudy->clinical_history = $request->clinical_history;
        $caseStudy->is_emergency = $request->emergency===null?0:1;
        $caseStudy->is_post_operative = $request->post_operative===null?0:1;
        $caseStudy->is_follow_up = $request->follow_up===null?0:1;
        $caseStudy->is_subspecialty = $request->subspecialty===null?0:1;
        $caseStudy->is_callback = $request->callback===null?0:1;
        $caseStudy->ref_by = $request->ref_by;
        $caseStudy->save();
        
        patient::where('id', $caseStudy->patient_id)
            ->update(
            [
                'name' => $request->patient_name,
                'age' => $request->age,
                'gender' => $request->gender,
                'clinical_history' => $request->clinical_history,
            ]);
        return response()->json(['status'=>'success', 'message' => [$this->getMessages('_UPSUMSG')]]);
    }

    public function updateCaseStudyImage(Request $request){
        if(!$request->hasFile('images')){
            return response()->json(['error'=>[$this->getMessages('_IMERROR')]]);
        }

        $studyImages = studyImages::where("case_study_id", $request->case_study_id)->get();
        if(count($studyImages) > 0){
            foreach($studyImages as $image){
                $image->delete();
                $imagePath = public_path('storage/' . $image->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
        }


        $caseStudy = caseStudy::find($request->case_study_id);
        $labName = $caseStudy->laboratory->lab_name;
        $patient_name = $caseStudy->patient->name;
        
        $oldUmask = umask(0002);
        foreach($request->file('images') as $image){
            $imageName = time().'_'.str_replace(" ", "_", $image->getClientOriginalName());
            $relativePath = 'uploads'.DIRECTORY_SEPARATOR . str_replace(" ", "_", $labName) . DIRECTORY_SEPARATOR . str_replace(" ", "_", $patient_name);
            $directoryPath = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR. $relativePath);
            
            // Manually create directory with correct permissions
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }

            $fullPath = $relativePath . DIRECTORY_SEPARATOR . $imageName;
            
            Storage::putFileAs('public'.DIRECTORY_SEPARATOR. $relativePath, $image, $imageName);
            umask($oldUmask);

            $studyImage = new studyImages;
            $studyImage->case_study_id = $caseStudy->id;
            $studyImage->image = $fullPath;
            $studyImage->save();
        }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }

    public function downloadImagesZip($id){
        if(empty($id)){
            abort(404, 'Case Study not found.');
        }
        $caseStudy = caseStudy::find($id);
        if(!$caseStudy){
            abort(404, 'Case Study not found.');
        }
        $zipFileName = str_replace(" ","_", $caseStudy->patient->name).'_'.$caseStudy->case_study_id.'_images.zip';
        $zip = new ZipArchive;

        $tempFile = tempnam(sys_get_temp_dir(), $zipFileName);

        if ($zip->open($tempFile, ZipArchive::CREATE) === TRUE) {

            foreach ($caseStudy->images as $file) {
                $filePath = storage_path('app/public/' . $file->image);
                $fileName = basename($file->image);
                $zip->addFile($filePath, $fileName);
            }

            $zip->close();

            return response()->download($tempFile, $zipFileName)->deleteFileAfterSend(true);
        } else {
            abort(404, 'Case Study not found.');
        }
    }
}
