<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;

use App\Models\doctor;
use App\Models\formField;
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
     * @param mixed $doc_primary_location
     * @param mixed $user_id
     * @return doctor
     */
    private function insertDocData($doc_name,$doc_login_email, $doc_primary_location, $user_id){
        $doctor = new doctor;
        $doctor->doc_name             = $doc_name;
        $doctor->doc_login_email      = $doc_login_email;
        $doctor->doc_primary_location = $doc_primary_location;
        $doctor->user_id              = $user_id;
        $doctor->status               = 1;
        $doctor->save();
        
        return $doctor;
    }
    
    /**
     * 
     * @param type $field_name
     * @param type $value
     * @param type $doctor_id
     * @return boolean|docFormFieldValue
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
     * 
     * @param type $doc_name
     * @param type $doc_location
     * @param type $doc_id
     */
    private function updateDocData($doc_name, $doc_location, $doc_id){
        doctor::where("id", $doc_id)
            ->update([
                "doc_name"             => $doc_name,
                "doc_primary_location" => $doc_location
            ]);
    }
    
    /**
     * 
     * @param type $field_name
     * @param type $value
     * @param type $doc_id
     * @return boolean
     */
    private function updateFormFieldValue($field_name, $value, $doc_id){
        $formField = formField::where("field_name", $field_name)
            ->first();
        
        if(!$formField){
            return false;
        }
        $authUser = Auth::user();
        
        $count = docFormFieldValue::where("form_field_id", $formField->id)
            ->where("doctor_id", $doc_id)
            ->count();
        
        if($count > 0){
            docFormFieldValue::where("form_field_id", $formField->id)
                ->where("doctor_id", $doc_id)
                ->update([
                    "value"      => $value,
                    "updated_by" => $authUser->id,
                ]);
        }
        else if(!empty($value)){
            $this->insertDocFormFieldValue($field_name, $value, $doc_id);
        }
    }
    
    /*================== STARTING OF PUBLIC FUNCTIONS =======================*/
    
    
    /**
     * Summary of addDoctor
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addDoctor(){
        $formFields = $this->getFormFields($this->roleId);
        return view("admin.addDoctor", ["formFields" => $formFields, "pageName" => $this->pageName]);
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
            'doctor_location' => 'required|min:3'
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
            $user = $this->insertUserData($request->doctor_name, $request->doctor_login_email);
            /*============== ADD DATA TO USER TABLE ============*/

            /*============== ADD DATA TO ROLE USER TABLE ============*/
            $roleUser = $this->insertRoleUserData($user->id, $this->roleId);
            /*============== ADD DATA TO ROLE USER TABLE ============*/
            
            /*============== ADD DATA TO WALLET TABLE ===============*/
            $this->insertIntoUserWalletData($user->id);
            /*============== ADD DATA TO WALLET TABLE ===============*/

            /*============== ADD DATA TO DOCTORS TABLE ============*/
            $doctor = $this->insertDocData($request->doctor_name, $request->doctor_login_email, $request->doctor_location, $user->id);
            /*============== ADD DATA TO DOCTORS TABLE ============*/

            /*============== ADD DATA TO FORM_FIELD_VALUES TABLE ============*/
            foreach($request->all() as $key=>$value){
                if(!empty($value)){
                    $this->insertDocFormFieldValue($key, $value, $doctor->id);
                }
            }
            /*============== ADD DATA TO FORM_FIELD_VALUES TABLE ============*/
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
     * 
     * @return type
     */
    public function viewDoctor(){
        $doctors = doctor::all();
        return view("admin.viewDoc", ["doctors" => $doctors, "pageName" => $this->pageName]);
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function changeDocStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'doc_id' => 'required|numeric|exists:doctors,id',
            'is_checked' => 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        $auth = Auth::user();
        $status = ($request->is_checked == 'true')?1:0;
        $deactivated_by = ($request->is_checked == 'true')?0:$auth->id;
        $deactivated_on = ($request->is_checked == 'true')?NULL:Carbon::now()->toDateTimeString();
        
        $doctor = doctor::find($request->doc_id);
        $doctor->status = $status;
        $doctor->deactivated_by = $deactivated_by;
        $doctor->deactivated_on = $deactivated_on;
        $doctor->save();
        
        $this->deActivateUser($doctor->doc_login_email, $status);
        return response()->json(['success' => [$this->getMessages('_STUPMSG')]]);
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function getEditDocData(Request $request){
        $validator = Validator::make($request->all(), [
            'doc_id' => 'required|numeric|exists:doctors,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        $formFields = $this->getFormFields($this->roleId);
        $doctor = doctor::where("id", $request->doc_id)
            ->with("docFormFieldValue")
            ->first();
        
        return view("admin.editDoc", ["doctor" => $doctor, "formFields" => $formFields, "pageName" => $this->pageName]);
    }
    
    public function updateDoc(Request $request){
        DB::beginTransaction();
        $formFields = $this->getFormFields($this->roleId);
        $validationArray = [
            'doc_id' => 'required|numeric|exists:doctors,id',
            'doc_name' => 'required|min:3',
            'doc_primary_location' => 'required|min:3'
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
            $this->updateUserData($request->doc_name, $doctor->user_id);
            /*============== ADD DATA TO USER TABLE ============*/
            
            /*============== UPDATE DATA TO LABORATORY TABLE ============*/
            $this->updateDocData($request->doc_name, $request->doc_primary_location, $request->doc_id);
            /*============== UPDATE DATA TO LABORATORY TABLE ============*/

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
