<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;
use App\Models\Collector;
use App\Models\formField;
use App\Models\collectorFormFieldValue;
use App\Traits\GeneralFunctionTrait;

class CollectorController extends Controller {

    use GeneralFunctionTrait;

    private $roleId = 6;
    private $pageName = "Collector";

    /**
     * 
     * @param type $collector_name
     * @param type $collector_login_email
     * @param type $collector_primary_location
     * @param type $user_id
     * @return \App\Http\Controllers\doctor
     */
    private function insertCollectorData($collector_name, $collector_login_email, $collector_primary_location, $user_id) {
        $collector = new Collector;
        $collector->collector_name = $collector_name;
        $collector->collector_login_email = $collector_login_email;
        $collector->collector_primary_location = $collector_primary_location;
        $collector->user_id = $user_id;
        $collector->status = 1;
        $collector->save();

        return $collector;
    }

    /**
     * 
     * @param type $field_name
     * @param type $value
     * @param type $collector_id
     * @return boolean|collectorFormFieldValue
     */
    private function insertCollectorFormFieldValue($field_name, $value, $collector_id) {
        $formField = formField::where("field_name", $field_name)
                ->first();

        if (!$formField) {
            return false;
        }
        $authUser = Auth::user();

        $formFieldValue = new collectorFormFieldValue();
        $formFieldValue->form_field_id = $formField->id;
        $formFieldValue->value = $value;
        $formFieldValue->collector_id = $collector_id;
        $formFieldValue->updated_by = $authUser->id;
        $formFieldValue->save();

        return $formFieldValue;
    }

    /**
     * 
     * @param type $collector_name
     * @param type $collector_location
     * @param type $collector_id
     */
    
    private function updateCollectorData($collector_name, $collector_location, $collector_id) {
        Collector::where("id", $collector_id)
            ->update([
                "collector_name" => $collector_name,
                "collector_primary_location" => $collector_location
        ]);
    }

    /**
     * 
     * @param type $field_name
     * @param type $value
     * @param type $collector_id
     * @return bool
     */
    private function updateFormFieldValue($field_name, $value, $collector_id) {
        $formField = formField::where("field_name", $field_name)
                ->first();

        if (!$formField) {
            return false;
        }
        $authUser = Auth::user();

        $count = collectorFormFieldValue::where("form_field_id", $formField->id)
                ->where("collector_id", $collector_id)
                ->count();

        if ($count > 0) {
            collectorFormFieldValue::where("form_field_id", $formField->id)
                    ->where("collector_id", $collector_id)
                    ->update([
                        "value" => $value,
                        "updated_by" => $authUser->id,
            ]);
        } else if (!empty($value)) {
            $this->insertCollectorFormFieldValue($field_name, $value, $collector_id);
        }
    }

    /* ================== STARTING OF PUBLIC FUNCTIONS ======================= */

    /**
     * 
     * @return type
     */
    public function addCollector() {
        $formFields = $this->getFormFields($this->roleId);
        return view("admin.addCollector", ["formFields" => $formFields, "pageName" => $this->pageName]);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function insertCollector(Request $request) {
        DB::beginTransaction();
        $formFields = $this->getFormFields($this->roleId);
        $validationArray = [
            'collector_name' => 'required|min:3',
            'collector_login_email' => 'required|email|unique:users,email',
            'collector_location' => 'required|min:3'
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

        try {
            /* ============== ADD DATA TO USER TABLE ============ */
            $user = $this->insertUserData($request->collector_name, $request->collector_login_email, 'Collector');
            /* ============== ADD DATA TO USER TABLE ============ */

            /* ============== ADD DATA TO ROLE USER TABLE ============ */
            $roleUser = $this->insertRoleUserData($user->id, $this->roleId);
            /* ============== ADD DATA TO ROLE USER TABLE ============ */

            /* ============== ADD DATA TO WALLET TABLE =============== */
            $this->insertIntoUserWalletData($user->id);
            /* ============== ADD DATA TO WALLET TABLE =============== */

            /* ============== ADD DATA TO COLLECTORS TABLE ============ */
            $collector = $this->insertCollectorData($request->collector_name, $request->collector_login_email, $request->collector_location, $user->id);
            /* ============== ADD DATA TO COLLECTORS TABLE ============ */

            /* ============== ADD DATA TO FORM_FIELD_VALUES TABLE ============ */
            foreach ($request->all() as $key => $value) {
                if (!empty($value)) {
                    $this->insertCollectorFormFieldValue($key, $value, $collector->id);
                }
            }
            /* ============== ADD DATA TO FORM_FIELD_VALUES TABLE ============ */
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => [$this->getMessages('_GNERROR')]]);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return response()->json(['error' => [$this->getMessages('_DBERROR')]]);
        }
        return response()->json(['success' => [$this->getMessages('_SVSUMSG')]]);
    }

    /**
     * 
     * @return type
     */
    public function viewCollector() {
        $collectors = collector::with('user.wallet')
                ->get();
        return view("admin.viewCollector", ["collectors" => $collectors, "pageName" => $this->pageName]);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function getEditCollectorData(Request $request) {
        $validator = Validator::make($request->all(), [
            'collector_id' => 'required|numeric|exists:collectors,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $formFields = $this->getFormFields($this->roleId);
        $collector = Collector::where("id", $request->collector_id)
                ->with("collectorFormFieldValue")
                ->first();
        return view("admin.editCollector", ["collector" => $collector, "formFields" => $formFields, "pageName" => $this->pageName]);
    }

    public function updateCollector(Request $request) {
        DB::beginTransaction();
        $formFields = $this->getFormFields($this->roleId);
        $validationArray = [
            'collector_id' => 'required|numeric|exists:collectors,id',
            'collector_name' => 'required|min:3',
            'collector_primary_location' => 'required|min:3'
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

        $collector = Collector::find($request->collector_id);
        try {
            /* ============== ADD DATA TO USER TABLE ============ */
            $this->updateUserData($request->collector_name, $collector->user_id);
            /* ============== ADD DATA TO USER TABLE ============ */

            /* ============== UPDATE DATA TO LABORATORY TABLE ============ */
            $this->updateCollectorData($request->collector_name, $request->collector_primary_location, $request->collector_id);
            /* ============== UPDATE DATA TO LABORATORY TABLE ============ */

            /* ============== UPDATE DATA TO FORM_FIELD_VALUES TABLE ============ */
            foreach ($request->all() as $key => $value) {
                $this->updateFormFieldValue($key, $value, $request->collector_id);
            }
            /* ============== UPDATE DATA TO FORM_FIELD_VALUES TABLE ============ */
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => [$ex->getMessage()]]);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return response()->json(['error' => [$this->getMessages('_DBERROR')]]);
        }
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }
    
    public function changeCollectorStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'collector_id' => 'required|numeric|exists:collectors,id',
            'is_checked' => 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        $auth = Auth::user();
        $status = ($request->is_checked == 'true')?1:0;
        $deactivated_by = ($request->is_checked == 'true')?0:$auth->id;
        $deactivated_on = ($request->is_checked == 'true')?NULL:Carbon::now()->toDateTimeString();
        
        $collector = Collector::find($request->collector_id);
        $collector->status = $status;
        $collector->deactivated_by = $deactivated_by;
        $collector->deactivated_on = $deactivated_on;
        $collector->save();
        
        $this->deActivateUser($collector->collector_login_email, $status);
        return response()->json(['success' => [$this->getMessages('_STUPMSG')]]);
    }
}
