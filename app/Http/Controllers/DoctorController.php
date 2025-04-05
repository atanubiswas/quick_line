<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;

use App\Models\Doctor;
use App\Models\formField;
use App\Models\Modality;
use App\Models\DoctorModality;
use App\Models\docFormFieldValue;

use App\Traits\GeneralFunctionTrait;

class DoctorController extends Controller
{
    use GeneralFunctionTrait;
    private $roleId = 4;
    private $pageName = "Doctor";
    
    /**
     * Summary of insertDocData
     * @param mixed $doc_name
     * @param mixed $doc_login_email
     * @param mixed $doc_phone_number
     * @param mixed $user_id
     * @return doctor
     */
    private function insertDocData($doc_name,$doc_login_email, $doc_phone_number, $user_id){
        $doctor = new doctor;
        $doctor->name           = $doc_name;
        $doctor->email          = $doc_login_email;
        $doctor->phone_number   = $doc_phone_number;
        $doctor->user_id        = $user_id;
        $doctor->status         = '1';
        $doctor->save();
        
        $msg = $this->generateLoggedMessage("add", 'Doctor', $doctor->name);
        $this->addLog('doctor', 'doctor_id', $doctor->id, 'add', $msg);
        
        return $doctor;
    }
    
    /**
     * Summary of insertDocFormFieldValue
     * @param mixed $field_name
     * @param mixed $value
     * @param mixed $doctor_id
     * @return bool|docFormFieldValue
     */
    private function insertDocFormFieldValue($field_name, $value, $doctor_id){
        $formField = formField::where("field_name", $field_name)
            ->first();
        
        if(!$formField){
            return false;
        }
        $authUser = Auth::user();
        
        $formFieldValue = new docFormFieldValue();
        $formFieldValue->form_field_id  = $formField->id;
        $formFieldValue->value          = $value;
        $formFieldValue->doctor_id      = $doctor_id;
        $formFieldValue->updated_by     = $authUser->id;
        $formFieldValue->save();
        
        return $formFieldValue;
    }
    
    /**
     * Summary of updateDocData
     * @param mixed $name
     * @param mixed $phone_number
     * @param mixed $modality
     * @param mixed $doc_id
     * @return void
     */
    private function updateDocData($name, $phone_number, $modalityes, $doc_id){
        $docOldData = doctor::find($doc_id);
        if ($docOldData->name !== $name) {
            $msg = $this->generateLoggedMessage("update", "Doctor", $docOldData->name, "Doctor Name", $docOldData->name, $name);
            $this->addLog("doctor", "doctor_id", $doc_id, "update", $msg, "Doctor Name", $docOldData->name, $name);
        }
        if ($docOldData->phone_number !== $phone_number) {
            $msg = $this->generateLoggedMessage("update", "Doctor", $docOldData->phone_number, "Phone Number", $docOldData->phone_number, $phone_number);
            $this->addLog("doctor", "doctor_id", $doc_id, "update", $msg, "Phone Number", $docOldData->phone_number, $phone_number);
        }
        doctor::where("id", $doc_id)
            ->update([
                "name"         => $name,
                "phone_number" => $phone_number
            ]);
        /*============= ADD DATE TO DOCTOR MODALITY TABLE ===============*/
        $oldModality = $this->getDoctorModalityList($doc_id, 0);
        $allModalityList = Modality::all();
        $newModalityArray = array();
        DoctorModality::where("doctor_id", $doc_id)
            ->update(["status" => '0']);
        foreach($modalityes as $modality){
            foreach($allModalityList as $modalityList){
                if($modalityList->id == $modality){
                    $newModalityArray[] = $modalityList->name;
                    break;
                }
            }
            DoctorModality::updateOrCreate(
                ["doctor_id" => $doc_id, "modality_id" => $modality],
                ["status" => '1']);
        }
        $newModality = implode(', ', $newModalityArray);
        if(trim(strtolower($oldModality)) !== trim(strtolower($newModality))){
            $msg = $this->generateLoggedMessage("update", "Doctor", $oldModality, "Modality", $oldModality, $newModality);
            $this->addLog("doctor", "doctor_id", $doc_id, "update", $msg, "Modality", $oldModality, $newModality);
        }
        /*============= ADD DATE TO DOCTOR MODALITY TABLE ===============*/
    }
    
    /**
     * Summary of updateFormFieldValue
     * @param mixed $field_name
     * @param mixed $value
     * @param mixed $doc_id
     * @return bool
     */
    private function updateFormFieldValue($field_name, $value, $doc_id): bool{
        $formField = formField::where("field_name", $field_name)
            ->first();
        
        if(!$formField){
            return false;
        }
        $authUser = Auth::user();
        
        $docOldData = docFormFieldValue::where("form_field_id", $formField->id)
            ->where("doctor_id", $doc_id)
            ->first();

        if ($docOldData && $value !== $docOldData->value) {
            docFormFieldValue::where("form_field_id", $formField->id)
                ->where("doctor_id", $doc_id)
                ->update([
                    "value" => $value,
                    "updated_by" => $authUser->id,
                ]);
            $msg = $this->generateLoggedMessage("update", "Doctor", '', $field_name, $docOldData->value, $value);
            $this->addLog("doctor", "doctor_id", $doc_id, "update", $msg, $field_name, $docOldData->value, $value);
        } else if (!$docOldData && !empty($value) && !is_array($value)) {
            $this->insertDocFormFieldValue($field_name, $value, $doc_id);
            $msg = $this->generateLoggedMessage("update", "Doctor", '', $field_name, 'N/A', $value);
            $this->addLog("doctor", "doctor_id", $doc_id, "update", $msg, $field_name, 'N/A', $value);
        }
        return TRUE;
    }
    
    /*================== STARTING OF PUBLIC FUNCTIONS =======================*/
    
    
    /**
     * Summary of addDoctor
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addDoctor(){
        $modalityes = Modality::all();
        $formFields = $this->getFormFields($this->roleId);
        return view("admin.addDoctor", ["modalityes" => $modalityes, "formFields" => $formFields, "pageName" => $this->pageName]);
    }
    
    /**
     * 
     * @param Request $request
     */
    public function insertDoctor(Request $request) {
        DB::beginTransaction();
        $formFields = $this->getFormFields($this->roleId);
        $validationArray = [
            'doctor_name' => 'required|min:3',
            'doctor_login_email' => 'required|email|unique:users,email',
            'doctor_phone_number' => 'required',
            'modality'=> 'required',
        ];
        foreach($formFields as $formField){
            if($formField->FormField->required == 1){
                $validationArray[$formField->FormField->field_name] = 'required';
            }
        }
        $validator = Validator::make($request->all(), $validationArray);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        try{
            /*============== ADD DATA TO USER TABLE ============*/
            $user = $this->insertUserData($request->doctor_name, $request->doctor_login_email, 'Doctor');
            /*============== ADD DATA TO USER TABLE ============*/

            /*============== ADD DATA TO ROLE USER TABLE ============*/
            $roleUser = $this->insertRoleUserData($user->id, $this->roleId);
            /*============== ADD DATA TO ROLE USER TABLE ============*/

            /*============== ADD DATA TO DOCTORS TABLE ============*/
            $doctor = $this->insertDocData($request->doctor_name, $request->doctor_login_email, $request->doctor_phone_number, $user->id);
            /*============== ADD DATA TO DOCTORS TABLE ============*/

            /*============== ADD DATA TO FORM_FIELD_VALUES TABLE ============*/
            foreach($request->all() as $key=>$value){
                if(!empty($value) && !is_array($value)){
                    $this->insertDocFormFieldValue($key, $value, $doctor->id);
                }
            }
            /*============== ADD DATA TO FORM_FIELD_VALUES TABLE ============*/

            /*============= ADD DATE TO DOCTOR MODALITY TABLE ===============*/
            foreach($request->modality as $modality){
                $docModality = new DoctorModality();
                $docModality->doctor_id = $doctor->id;
                $docModality->modality_id = $modality;
                $docModality->save();
            }
            /*============= ADD DATE TO DOCTOR MODALITY TABLE ===============*/
            DB::commit();
        }
        catch(\Exception $ex) {
            DB::rollback();
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
        return response()->json(['success' => [$this->getMessages('_SVSUMSG')]]);
    }
    
    /**
     * Summary of viewDoctor
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewDoctor(){
        $doctors = doctor::with('DoctorModality.Modality')->get();
        return view("admin.viewDoc", ["doctors" => $doctors, "pageName" => $this->pageName]);
    }
    
    /**
     * Summary of changeDocStatus
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function changeDocStatus(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'doc_id' => 'required|numeric|exists:doctors,id',
                'is_checked' => 'required'
            ]);
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()]);
            }
            $status = ($request->is_checked == 'true')?'1':'0';
            $statusString = ($status === '1') ?'active':'inactive';

            $doctor = doctor::find($request->doc_id);
            $doctor->status = $status;
            $doctor->save();
            
            $this->deActivateUser($doctor->doc_login_email, $status);
            $msg = $this->generateLoggedMessage($statusString, "Doctor", $doctor->name);
            $this->addLog("doctor", "doctor_id", $request->doc_id, $statusString, $msg);
        }
        catch(\Exception $ex) {
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        } catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
        return response()->json(['success' => [$this->getMessages('_STUPMSG')]]);
    }
    
    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function getEditDocData(Request $request){
        $validator = Validator::make($request->all(), [
            'doc_id' => 'required|numeric|exists:doctors,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        $formFields = $this->getFormFields($this->roleId);
        $formFieldsValues = $this->getDocFormFieldValues($request->doc_id);
        $doctor = doctor::where("id", $request->doc_id)
            ->with("doctorFormFieldValue", "DoctorModality.Modality")
            ->first();
        $docModalityArray = array();
        foreach($doctor->DoctorModality as $docModality){
            $docModalityArray[] = $docModality->Modality->id;
        }
        $modalityes = Modality::all();

        return view("admin.editDoc", ["doctor" => $doctor, "formFields" => $formFields, "formFieldsValues" => $formFieldsValues, "modalityes" => $modalityes, "docModalityArray" => $docModalityArray, "pageName" => $this->pageName]);
    }
    
    public function updateDoc(Request $request){
        DB::beginTransaction();
        $formFields = $this->getFormFields($this->roleId);
        $validationArray = [
            'doc_id' => 'required|numeric|exists:doctors,id',
            'name' => 'required|min:3',
            'phone_number' => 'required',
            'modality' => 'required',
        ];
        foreach($formFields as $formField){
            if($formField->FormField->required == 1){
                $validationArray[$formField->FormField->field_name] = 'required';
            }
        }
        $validator = Validator::make($request->all(), $validationArray);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        $doctor = doctor::find($request->doc_id);
        try{
            /*============== ADD DATA TO USER TABLE ============*/
            $this->updateUserData($request->name, $doctor->user_id);
            /*============== ADD DATA TO USER TABLE ============*/
            
            /*============== UPDATE DATA TO DOCTOR TABLE ============*/
            $this->updateDocData($request->name, $request->phone_number, $request->modality, $request->doc_id);
            /*============== UPDATE DATA TO DOCTOR TABLE ============*/

            /*============== UPDATE DATA TO FORM_FIELD_VALUES TABLE ============*/
            foreach($request->all() as $key=>$value){
                $this->updateFormFieldValue($key, $value, $request->doc_id);
            }
            /*============== UPDATE DATA TO FORM_FIELD_VALUES TABLE ============*/
            DB::commit();
        }
        catch(\Exception $ex) {
            DB::rollback();
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }
}
