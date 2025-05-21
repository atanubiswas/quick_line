<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;

use App\Models\Doctor;
use App\Models\Modality;
use App\Models\formField;
use App\Models\Laboratory;
use App\Models\LabModality;
use App\Models\DoctorModality;
use App\Models\LabFormFieldValue;
use App\Models\lab_preferred_doctor;
use App\Models\lab_black_listed_doctor;
use App\Models\CollectorLabAssociation;

use App\Traits\GeneralFunctionTrait;

class LaboratoryController extends Controller
{
    use GeneralFunctionTrait;
    private $roleId = 3;
    private $pageName = "Centre";

    /**
     * *
     * @param mixed $lab_name
     * @param mixed $lab_email
     * @param mixed $lab_location
     * @param mixed $lab_phone_number
     * @param mixed $user_id
     * @return Laboratory
     */
    private function insertLabData($lab_name, $lab_email, $lab_location, $lab_phone_number, $user_id)
    {
        $labratory = new Laboratory;
        $labratory->lab_name = ucwords($lab_name);
        $labratory->lab_login_email = $lab_email;
        $labratory->lab_primary_location = $lab_location;
        $labratory->lab_phone_number = $lab_phone_number;
        $labratory->user_id = $user_id;
        $labratory->status = 1;
        $labratory->save();

        $msg = $this->generateLoggedMessage("add", 'Centre', $labratory->lab_name);
        $this->addLog('laboratory', 'laboratorie_id', $labratory->id, 'add', $msg);
        return $labratory;
    }

    /**
     * Summary of insertLabFormFieldValue
     * @param mixed $field_name
     * @param mixed $value
     * @param mixed $labrotory_id
     * @return bool|LabFormFieldValue
     */
    private function insertLabFormFieldValue($field_name, $value, $labrotory_id)
    {
        $formField = formField::where("field_name", $field_name)
            ->first();

        if (!$formField) {
            return false;
        }
        $authUser = Auth::user();

        $formFieldValue = new LabFormFieldValue();
        $formFieldValue->form_field_id = $formField->id;
        $formFieldValue->value = $value;
        $formFieldValue->laboratorie_id = $labrotory_id;
        $formFieldValue->updated_by = $authUser->id;
        $formFieldValue->save();

        return $formFieldValue;
    }

    /**
     * Summary of updateLabData
     * @param mixed $lab_name
     * @param mixed $lab_location
     * @param mixed $lab_phone_number
     * @param mixed $lab_id
     * @return void
     */
    private function updateLabData($lab_name, $lab_location, $lab_phone_number, $lab_id, $modalityes){
        $labOldData = Laboratory::find($lab_id);
        if ($labOldData->lab_name !== $lab_name) {
            $msg = $this->generateLoggedMessage("update", "Centre", $labOldData->lab_name, "Centre Name", $labOldData->lab_name, $lab_name);
            $this->addLog("laboratory", "laboratorie_id", $lab_id, "update", $msg, "Centre Name", $labOldData->lab_name, $lab_name);
        }
        if ($labOldData->lab_primary_location !== $lab_location) {
            $msg = $this->generateLoggedMessage("update", "Centre", $labOldData->lab_primary_location, "Centre Location", $labOldData->lab_primary_location, $lab_location);
            $this->addLog("laboratory", "laboratorie_id", $lab_id, "update", $msg, "Centre Location", $labOldData->lab_primary_location, $lab_location);
        }
        if ($labOldData->lab_phone_number !== $lab_phone_number) {
            $msg = $this->generateLoggedMessage("update", "Centre", $labOldData->lab_phone_number, "Centre Phone Number", $labOldData->lab_phone_number, $lab_phone_number);
            $this->addLog("laboratory", "laboratorie_id", $lab_id, "update", $msg, "Centre Phon Number", $labOldData->lab_phone_number, $lab_phone_number);
        }

        $oldModality = $this->getLabModalityList($lab_id, 0);
        $allModalityList = Modality::all();
        $newModalityArray = array();
        LabModality::where("laboratory_id", $lab_id)
            ->update(["status" => '0']);
        foreach($modalityes as $modality){
            foreach($allModalityList as $modalityList){
                if($modalityList->id == $modality){
                    $newModalityArray[] = $modalityList->name;
                    break;
                }
            }
            LabModality::updateOrCreate(
                ["laboratory_id" => $lab_id, "modality_id" => $modality],
                ["status" => '1']);
        }

        Laboratory::where("id", $lab_id)
        ->update([
            "lab_name" => $lab_name,
            "lab_primary_location" => $lab_location,
            "lab_phone_number" => $lab_phone_number
        ]);
    }

    /**
     * Summary of updateLabFormFieldValue
     * @param mixed $field_name
     * @param mixed $value
     * @param mixed $lab_id
     * @return bool
     */
    private function updateLabFormFieldValue($field_name, $value, $lab_id)
    {
        $formField = formField::where("field_name", $field_name)
            ->first();
          
        if (!$formField) {
            return false;
        }
        
        $authUser = Auth::user();

        $labOldData = LabFormFieldValue::where("form_field_id", $formField->id)
            ->where("laboratorie_id", $lab_id)
            ->first();

        if ($labOldData && $value !== $labOldData->value) {
            LabFormFieldValue::where("form_field_id", $formField->id)
                ->where("laboratorie_id", $lab_id)
                ->update([
                    "value" => $value,
                    "updated_by" => $authUser->id,
                ]);
            $msg = $this->generateLoggedMessage("update", "Centre", '', $field_name, $labOldData->value, $value);
            $this->addLog("laboratory", "laboratorie_id", $lab_id, "update", $msg, $field_name, $labOldData->value, $value);
        } else if (!$labOldData && !empty($value)) {
            $this->insertLabFormFieldValue($field_name, $value, $lab_id);
            $msg = $this->generateLoggedMessage("update", "Centre", '', $field_name, 'N/A', $value);
            $this->addLog("laboratory", "laboratorie_id", $lab_id, "update", $msg, $field_name, 'N/A', $value);
        }
        return true;
    }

    /*================== STARTING OF PUBLIC FUNCTIONS =======================*/


    /**
     * Summary of addLab
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addLab()
    {
        $modalityes = Modality::all();
        $formFields = $this->getFormFields($this->roleId);
        return view("admin.addLab", ["formFields" => $formFields, "modalityes" => $modalityes, "pageName" => $this->pageName]);
    }

    /**
     * Summary of insertLab
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function insertLab(Request $request)
    {
        DB::beginTransaction();
        $formFields = $this->getFormFields($this->roleId);
        $validationArray = [
            'lab_name' => 'required|min:3',
            'lab_login_email' => 'required|email|unique:users,email',
            'lab_primary_location' => 'required|min:3',
            'lab_phone_number' => 'required',
            'modality'=> 'required',
        ];
        foreach ($formFields as $formField) {
            if ($formField->FormField->required == 1) {
                $validation = 'required';
                if (in_array($formField->FormField->id, [12,13,141,15])) {
                    $validation .= '|numeric';
                }
                $validationArray[$formField->FormField->field_name] = $validation;
            }
        }
        $validator = Validator::make($request->all(), $validationArray);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        try{
        /*============== ADD DATA TO USER TABLE ============*/
        $user = $this->insertUserData($request->lab_name, $request->lab_login_email, 'Laboratory');
        /*============== ADD DATA TO USER TABLE ============*/

        /*============== ADD DATA TO ROLE USER TABLE ============*/
        $roleUser = $this->insertRoleUserData($user->id, $this->roleId);
        /*============== ADD DATA TO ROLE USER TABLE ============*/

        /*============== ADD DATA TO LABORATORY TABLE ============*/
        $labrotory = $this->insertLabData($request->lab_name, $request->lab_login_email, $request->lab_primary_location, $request->lab_phone_number, $user->id);
        /*============== ADD DATA TO LABORATORY TABLE ============*/

        /*============== ADD DATA TO FORM_FIELD_VALUES TABLE ============*/
        foreach ($request->all() as $key => $value) {
            if (!empty($value)) {
                if (is_array($value)) {
                    $value = implode(',', $value);
                }
                $this->insertlabFormFieldValue($key, $value, $labrotory->id);
            }
        }
        /*============== ADD DATA TO FORM_FIELD_VALUES TABLE ============*/

        /*============= ADD DATE TO LABORATORY MODALITY TABLE ===============*/
        foreach($request->modality as $modality){
            $labModality = new LabModality();
            $labModality->laboratory_id = $labrotory->id;
            $labModality->modality_id = $modality;
            $labModality->save();
        }
        /*============= ADD DATE TO LABORATORY MODALITY TABLE ===============*/
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
     * Summary of viewLab
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewLab()
    {
        $appliedLabs = $appliedLabId = array();
        $isAdmin = Auth::user()->hasRole('Admin');
        $labratoryes = Laboratory::with('user')
            ->when($isAdmin === false, function ($query) {
                $query->where('status', 1);
            })
            ->with("labModality.modality")
            ->get();
        $pageName = $this->pageName;
        return view("admin.viewLab", compact("labratoryes", "pageName", "isAdmin", "appliedLabs"));
    }

    /**
     * Summary of changeLabStatus
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function changeLabStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lab_id' => 'required|numeric|exists:laboratories,id',
            'is_checked' => 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $status = ($request->is_checked == 'true') ? 1 : 0;
        $statusString = ($status == 1) ?'active':'inactive';

        $laboratory = Laboratory::find($request->lab_id);
        $laboratory->status = $status;
        $laboratory->save();

        $loginEmail = $laboratory->user->email;
        $this->deActivateUser($loginEmail, $status);

        $msg = $this->generateLoggedMessage($statusString, "Centre", $laboratory->lab_name);
        $this->addLog("laboratory", "laboratorie_id", $request->lab_id, $statusString, $msg);
        return response()->json(['success' => [$this->getMessages('_STUPMSG')]]);
    }

    /**
     * Summary of getEditLabData
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function getEditLabData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lab_id' => 'required|numeric|exists:laboratories,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $formFields = $this->getFormFields($this->roleId);
        $formFieldsValues = $this->getLabFormFieldValues($request->lab_id);
        $labratory = Laboratory::where("id", $request->lab_id)
            ->with("labFormFieldValue")
            ->with("labModality.modality")
            ->first();
        $labModalityArray = array();
        foreach($labratory->labModality as $labModality){
            $labModalityArray[] = $labModality->Modality->id;
        }
        $modalityes = Modality::all();
        return view("admin.editLab", ["labratory" => $labratory, "formFields" => $formFields, "formFieldsValues" => $formFieldsValues, "pageName" => $this->pageName, "labModalityArray" => $labModalityArray, "modalityes" => $modalityes]);
    }

    /**
     * Summary of updateLab
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function updateLab(Request $request)
    {
        DB::beginTransaction();
        $formFields = $this->getFormFields($this->roleId);

        $validationArray = [
            'lab_id' => 'required|numeric|exists:laboratories,id',
            'lab_name' => 'required|min:3',
            'lab_primary_location' => 'required|min:3',
            'lab_phone_number' => 'required',
            'modality' => 'required',
        ];
        foreach ($formFields as $formField) {
            if ($formField->FormField->required == 1) {
                $validation = 'required';
                if (in_array($formField->FormField->id, [12,13,141,15])) {
                    $validation .= '|numeric';
                }
                $validationArray[$formField->FormField->field_name] = $validation;
            }
        }
        $validator = Validator::make($request->all(), $validationArray);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $labrotory = Laboratory::find($request->lab_id);
        //try {
            /*============== ADD DATA TO USER TABLE ============*/
            $this->updateUserData($request->lab_name, $labrotory->user_id);
            /*============== ADD DATA TO USER TABLE ============*/

            /*============== UPDATE DATA TO LABORATORY TABLE ============*/
            $this->updateLabData($request->lab_name, $request->lab_primary_location, $request->lab_phone_number, $request->lab_id, $request->modality);
            /*============== UPDATE DATA TO LABORATORY TABLE ============*/

            /*============== UPDATE DATA TO FORM_FIELD_VALUES TABLE ============*/
            foreach ($request->all() as $key => $value) {
                $this->updateLabFormFieldValue($key, $value, $request->lab_id);
            }
            /*============== UPDATE DATA TO FORM_FIELD_VALUES TABLE ============*/
            DB::commit();
        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return response()->json(['error' => [$this->getMessages('_GNERROR')]]);
        // } catch (\Illuminate\Database\QueryException $ex) {
        //     DB::rollback();
        //     return response()->json(['error' => [$this->getMessages('_DBERROR')]]);
        // }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }

    /**
     * Summary of getAssignedCollectors
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function getAssignedCollectors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lab_id' => 'required|numeric|exists:laboratories,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $lab = Laboratory::find($request->lab_id);
        $collectors = CollectorLabAssociation::selectRaw("*, CASE 
                      WHEN status = 'applied' THEN 'bg-info'
                      WHEN status = 'processed' THEN 'bg-warning'
                      WHEN status = 'approved' THEN 'bg-success'
                      WHEN status = 'rejected' THEN 'bg-danger'
                      ELSE ''
                  END AS button_type")
            ->where("laboratories_id", $request->lab_id)
            ->with("collector")
            ->get();
        return view("admin.assignedCollectors", compact("lab", "collectors"));
    }

    /**
     * Summary of getNearbyLabs
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getNearbyLabs(Request $request)
    {
        $labs = Laboratory::where('status', 1)
            ->get();

        return $this->returnAPIResponse('Success', 200, ['lab_data' => $labs]);
    }

    /**
     * Summary of searchAll
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function searchAll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_text' => 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $labs = Laboratory::where('status', 1)
            ->get();

        return $this->returnAPIResponse('Success', 200, ['lab_data' => $labs]);
    }

    public function getPreferredDoctors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lab_id' => 'required|numeric|exists:laboratories,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $lab = Laboratory::find($request->lab_id);
        $modalities = Modality::orderBy('name')
            ->get();
        $doctors = Doctor::where('status', '1')
            ->orderBy('name')
            ->get();
        
        $preferredDoctors = lab_preferred_doctor::where('laboratorie_id', $request->lab_id)
            ->get();
        $preferredDoctorIds = $preferredDoctors->pluck('doctor_id')->toArray();

        $labBlackListedDoctorIds = lab_black_listed_doctor::where('laboratorie_id', $request->lab_id)
            ->where('status', 1)
            ->pluck('doctor_id')
            ->toArray();
        
        foreach($modalities as $modality){
            $tempArray = array();
            $docModality = DoctorModality::select("doctors.*")
                ->leftJoin('doctors', 'doctors.id', '=', 'doctor_id')
                ->where('modality_id', $modality->id)
                ->where('doctors.status', '1')
                ->orderBy('name')
                ->get();
            foreach($docModality as $dm){
                $tempArray[] = $dm;
            }
            $modality['doctor'] = $tempArray;
        }
        return view("admin.preferredDoctor", compact("lab", "doctors", "modalities", "preferredDoctors", 'preferredDoctorIds', 'labBlackListedDoctorIds'));
    }

    /**
     * Summary of getModality
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function getModality(Request $request){
        $validator = Validator::make($request->all(), [
            'lab_id' => 'required|numeric|exists:laboratories,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $labModalities = LabModality::where('laboratory_id', $request->lab_id)
            ->with("modality")
            ->where("status", 1)
            ->get();
            
        return view("admin.getModality", compact("labModalities"));
    }

    /**
     * Summary of getStudy
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function getStudy(Request $request){
        $validator = Validator::make($request->all(), [
            'lab_id' => 'required|numeric|exists:laboratories,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $lab = Laboratory::find($request->lab_id);
        $caseStudies = $lab->caseStudy;
        return view("admin.getStudy", compact("caseStudies", "lab"));
    }

    public function updatePreferredDoctors(Request $request){
        $labId = $request->lab_id;
        $labOldData = Laboratory::find($labId);
        foreach($request->all() as $key => $value){
            $mArray = explode("modality_", $key);
            if(!isset($mArray[1])){continue;}
            $modalityId = $mArray[1];
            if($key == 'lab_id'){
                continue;
            }
            else if(empty($value)){
                lab_preferred_doctor::where('laboratorie_id', $labId)
                    ->where('modality_id', $modalityId)
                    ->delete();
            }
            else{
                lab_preferred_doctor::updateOrCreate([
                    "laboratorie_id" => $labId,
                    "doctor_id" => $value,
                    "modality_id" => $modalityId
                ], []);
            }
        }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }

    public function updateBlackListedDoctors(Request $request){
        $labId = $request->lab_id;
        lab_black_listed_doctor::where('laboratorie_id', $labId)
            ->update(["status" => 0]);
        if(!isset($request->doctors)){
            return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
        }
        foreach($request->doctors as $doctor){
            lab_black_listed_doctor::updateOrCreate([
                "laboratorie_id" => $labId,
                "doctor_id" => $doctor,
            ], [
                "status" => 1
            ]);
        }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }

    public function labPageSetup(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'lab_id' => 'required|numeric|exists:laboratories,id'
        // ]);
        // if (!$validator->passes()) {
        //     return response()->json(['error' => $validator->errors()]);
        // }
        return view("admin.labPageSetup");
    }
}
