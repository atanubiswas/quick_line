<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;

use App\Models\formField;
use App\Models\Laboratory;
use App\Models\LabFormFieldValue;
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
    private function updateLabData($lab_name, $lab_location, $lab_phone_number, $lab_id)
    {
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
        $formFields = $this->getFormFields($this->roleId);
        return view("admin.addLab", ["formFields" => $formFields, "pageName" => $this->pageName]);
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
            'lab_phone_number' => 'required'
        ];
        foreach ($formFields as $formField) {
            if ($formField->FormField->required == 1) {
                $validationArray[$formField->FormField->field_name] = 'required';
            }
        }
        $validator = Validator::make($request->all(), $validationArray);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        try{
        /*============== ADD DATA TO USER TABLE ============*/
        $user = $this->insertUserData($request->lab_name, $request->lab_login_email);
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

        $this->deActivateUser($laboratory->lab_login_email, $status);

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
            ->first();

        return view("admin.editLab", ["labratory" => $labratory, "formFields" => $formFields, "formFieldsValues" => $formFieldsValues, "pageName" => $this->pageName]);
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
            'lab_phone_number' => 'required'
        ];
        foreach ($formFields as $formField) {
            if ($formField->FormField->required == 1) {
                $validationArray[$formField->FormField->field_name] = 'required';
            }
        }
        $validator = Validator::make($request->all(), $validationArray);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $labrotory = Laboratory::find($request->lab_id);
        try {
            /*============== ADD DATA TO USER TABLE ============*/
            $this->updateUserData($request->lab_name, $labrotory->user_id);
            /*============== ADD DATA TO USER TABLE ============*/

            /*============== UPDATE DATA TO LABORATORY TABLE ============*/
            $this->updateLabData($request->lab_name, $request->lab_primary_location, $request->lab_phone_number, $request->lab_id);
            /*============== UPDATE DATA TO LABORATORY TABLE ============*/

            /*============== UPDATE DATA TO FORM_FIELD_VALUES TABLE ============*/
            foreach ($request->all() as $key => $value) {
                $this->updateLabFormFieldValue($key, $value, $request->lab_id);
            }
            /*============== UPDATE DATA TO FORM_FIELD_VALUES TABLE ============*/
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => [$this->getMessages('_GNERROR')]]);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return response()->json(['error' => [$this->getMessages('_DBERROR')]]);
        }
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
}
