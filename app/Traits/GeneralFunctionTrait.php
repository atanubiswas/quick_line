<?php

namespace App\Traits;

use DB;
use Hash;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use App\Models\patient;
use App\Models\caseStudy;
use App\Models\DoctorLog;
use App\Models\role_user;
use App\Models\WalletUser;
use App\Models\Transaction;
use App\Models\LabModality;
use App\Models\FormFieldRole;
use App\Models\laboratoryLog;
use App\Models\DoctorModality;
use App\Models\LabFormFieldValue;
use App\Models\docFormFieldValue;

trait GeneralFunctionTrait{
    
    /**
     * 
     * @return 
     */
    private function getLoggedInUser(){
        $authUser = Auth::user();
        $roleUser = role_user::where("user_id", $authUser->id)
            ->first();
        $authUser->role = $roleUser->role;
        return $authUser;
    }
    /**
     * 
     * @return array
     */
    private static function generateContrastColors()
    {
        $background = self::generateRandomColor();
        $foreground = self::getContrastColor($background);

        return [
            'background' => $background,
            'foreground' => $foreground,
        ];
    }
    
    /**
     * 
     * @return string
     */
    private static function generateRandomColor()
    {
        return '#' . substr(md5(mt_rand()), 0, 6); // Generate a random hex color
    }
    
    /**
     * 
     * @param $hexColor
     * @return string
     */
    private static function getContrastColor($hexColor)
    {
        $hexColor = ltrim($hexColor, '#');
        $rgb = sscanf($hexColor, "%02x%02x%02x");
        $luminance = (0.299 * $rgb[0] + 0.587 * $rgb[1] + 0.114 * $rgb[2]) / 255;

        return $luminance > 0.5 ? '#000000' : '#ffffff';
    }
    
    /**
     * 
     * @param $roleId
     * @return Collection
     */
    private function getFormFields($roleId){
        $formFields = FormFieldRole::where("role_id", $roleId)
            ->with("FormField.formFieldOptions")
            ->get();
        return $formFields;
    }

    /**
     * @param mixed $labId
     * @return Collection
     */
    private function getLabFormFieldValues($labId){
        $LabFormValues = LabFormFieldValue::where("laboratorie_id", $labId)
        ->get();
        return $LabFormValues;
    }

    /**
     * Summary of getDocFormFieldValues
     * @param mixed $docId
     * @return Collection|docFormFieldValue[]
     */
    private function getDocFormFieldValues($docId){
        $DocFormValues = docFormFieldValue::where("doctor_id", $docId)
        ->get();
        return $DocFormValues;
    }
    
    /**
     * 
     * @param $userName
     * @return string
     */
    private function getUserImage($userName){
        $randomColorArray = $this->generateContrastColors();
        return config('mainConfig.USER_IMAGE_DEFAULT_URL')."?name=".str_replace(" ","+",$userName)."&background=".ltrim($randomColorArray['background'], "#")."&color=".ltrim($randomColorArray['foreground'], "#")."&size=150";
    }
    
    /**
     * 
     * @param string
     * @return string
     */
    private function getMessages($code){
        $messages = array(
            '_GNERROR' => 'Something Wrong happened, Please reload this page.',
            '_DBERROR' => 'Something Wrong happen to the Database, Please reload this page.',
            '_SVSUMSG' => 'Success! Data Saved.',
            '_UPSUMSG' => 'Success! Data Updated.',
            '_STUPMSG' => 'Success! Status Updated'
        );
        
        return isset($messages[$code])?$messages[$code]:"Error.";
    }
    
    /**
     * Summary of insertUserData
     * @param mixed $user_name
     * @param mixed $login_email
     * @param mixed $access_type
     * @param mixed $default_password
     * @return User
     */
    private function insertUserData($user_name, $login_email, $access_type, $default_password='Quick Line'){
        $userImage = $this->getUserImage($user_name);
        $user               = new User;
        $user->name         = $user_name;
        $user->email        = strtolower($login_email);
        $user->password     = Hash::make($default_password);
        $user->user_image   = $userImage;
        $user->access_type  = $access_type;
        $user->save();
        
        return $user;
    }
    
    /**
     * Summary of insertRoleUserData
     * @param mixed $user_id
     * @param mixed $roleId
     * @return role_user
     */
    private function insertRoleUserData($user_id, $roleId){
        $roleUser = new role_user;
        $roleUser->role_id = $roleId;
        $roleUser->user_id = $user_id;
        $roleUser->save();
        
        return $roleUser;
    }
    
    /**
     * Summary of updateUserData
     * @param mixed $user_name
     * @param mixed $user_id
     * @return void
     */
    private function updateUserData($user_name, $user_id){
        User::where("id", $user_id)
            ->update([
               "name"   => $user_name
            ]);
    }
    
    /**
     * Summary of deActivateUser
     * @param mixed $email
     * @param mixed $status
     * @return void
     */
    private function deActivateUser($email, $status){
        $status = (int) $status;
        $user = User::where("email", $email)
            ->update([
                "status" => $status
            ]);
    }
    
    /**
     * Summary of insertIntoUserWalletData
     * @param mixed $userId
     * @return WalletUser
     */
    private function insertIntoUserWalletData($userId){
        $walletUser = new WalletUser;
        $walletUser->user_id = $userId;
        $walletUser->save();
        
        return $walletUser;
    }
    
    /**
     * Summary of getWallet
     * @param mixed $user_id
     * @return array
     */
    private function getWallet($user_id): array{
        $returnArray = array();
        $WalletUser = WalletUser::where("user_id", $user_id)
            ->first();
        
        $returnArray['wallet_user_id'] = $WalletUser->id;
        $returnArray['previous_amount'] = $WalletUser->balance;
        $returnArray['after_amount'] = (float)$WalletUser->balance;
        return $returnArray;
    }
    
    /**
     * Summary of incrementWallet
     * @param mixed $user_id
     * @param mixed $amount
     * @return array
     */
    private function incrementWallet($user_id, $amount){
        $returnArray = array();
        $WalletUser = WalletUser::where("user_id", $user_id)
            ->first();
        
        $returnArray['wallet_user_id'] = $WalletUser->id;
        $returnArray['previous_amount'] = $WalletUser->balance;
        $returnArray['after_amount'] = (float)$WalletUser->balance + (float)$amount;
        $WalletUser->increment("balance", $amount);
        return $returnArray;
    }
    
    /**
     * Summary of decrementWallet
     * @param mixed $user_id
     * @param mixed $amount
     * @return object|WalletUser|\Illuminate\Database\Eloquent\Model|null
     */
    private function decrementWallet($user_id, $amount){
        $WalletUser = WalletUser::where("user_id", $user_id)
            ->first();
        
        $WalletUser->decrement("balance", $amount);
        return $WalletUser;
    }
    
    /**
     * Summary of addWalletTransaction
     * @param mixed $user_id
     * @param mixed $wallet_user_id
     * @param mixed $previous_amount
     * @param mixed $amount
     * @param mixed $after_amount
     * @param mixed $direction
     * @param mixed $transaction_type
     * @param mixed $notes
     * @param mixed $transaction_by_type
     * @param mixed $status
     * @return Transaction
     */
    private function addWalletTransaction($user_id, $wallet_user_id, $previous_amount, $amount, $after_amount, $direction, $transaction_type, $notes, $transaction_by_type, $status){
        $authUser = Auth::user();
        $transaction = new Transaction;
        $transaction->user_id = $user_id;
        $transaction->wallet_user_id = $wallet_user_id;
        $transaction->previous_amount = $previous_amount;
        $transaction->amount = $amount;
        $transaction->after_amount = $after_amount;
        $transaction->direction = $direction;
        $transaction->transaction_type = $transaction_type;
        $transaction->transaction_date = Carbon::now()->toDateTimeString();
        $transaction->notes = $notes;
        $transaction->uuid = Str::uuid();
        $transaction->transaction_by = $authUser->id;
        $transaction->transaction_by_type = $transaction_by_type;
        $transaction->status = $status;
        $transaction->save();
        
        return $transaction;
    }
    
    /**
     * Summary of validationErrorResponse
     * @param mixed $errors
     * @param int $status_code
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    private function validationErrorResponse($errors, int $status_code=200){
        return response()->json(['status'=>'Error', 'errors'=>$errors], $status_code);
    }
    
    /**
     * 
     * @param string $status The Return Status for the API
     * @param int $status_code The Return Status Code for the API
     * @param array $data The Return Data of the API is Exist
     * @param string $message The Return Message of the API
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    private function returnAPIResponse(string $status, int $status_code, $data, $message=''){
        if(!is_array($data) && !$data instanceof Collection && empty($message)){
            $message = $data;
            $data = array();
        }
        $returnArray = array();
        $returnArray['status'] = strtolower(trim($status));
        if(count($data) >0 ){$returnArray['data'] = $data;}
        if(!empty($message)){$returnArray['message'] = $message;}
        if($status_code==500 && empty($message)){$message = 'Somthing went wrong, Please restart.';}
        
        return response()->json($returnArray, $status_code);
    }
    
    /**
     * 
     * @param string $phoneNumber
     * @return string
     */
    private function formatMobileNumber(string $phoneNumber):string{
        $number = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Check if the number starts with a country code
        if (strlen($number) > 10) {
            $number = substr($number, -10); // Only take the last 10 digits
        }

        $formattedNumber = '+91 ' . substr($number, 0, 5) . ' ' . substr($number, 5);

        return $formattedNumber;
    }
    
    /**
     * 
     * @param int $length
     * @return string
     */
    private function generateRandomPassword(int $length = 10):string{
        // Define character sets to include in the password
        $chars = [
            'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'abcdefghijklmnopqrstuvwxyz',
            '0123456789',
            '!@#$%^&*()'
        ];

        $password = '';

        // Generate random characters to fill the password length
        for ($i = 0; $i < $length; $i++) {
            $charSet = $chars[rand(0, count($chars) - 1)];
            $password .= $charSet[rand(0, strlen($charSet) - 1)];
        }

        return $password;
    }
    
    /**
     * Summary of checkDuplicate
     * @param mixed $tableName
     * @param mixed $fieldName
     * @param mixed $value
     * @return bool
     */
    private function checkDuplicate($tableName, $fieldName, $value): bool{
        $count = DB::table($tableName)
                    ->where($fieldName, $value)
                    ->count();
        if($count === 0){
            return false;
        }
        return true;
    }

    /**
     * Summary of addLog
     * @param mixed $modelName
     * @param mixed $idColumnName
     * @param mixed $id
     * @param mixed $type
     * @param mixed $msg
     * @param mixed $columnName
     * @param mixed $old_data
     * @param mixed $new_data
     * @return void
     */
    private function addLog($modelName, $foreignKey, $id, $type, $msg, $columnName = null, $old_data = null, $new_data = null): void{
        $loggedInUser = $this->getLoggedInUser();
        $inputArray = array(
            'type'          => $type,
            $foreignKey     => $id,
            'log'           => $msg,
            'user_id'       => $loggedInUser->id,
            'column_name'   => $columnName,
            'old_value'     => $old_data,
            'new_value'     => $new_data
        );
        switch($modelName){
            case 'laboratory':
                laboratoryLog::create($inputArray);
                break;

            case 'doctor':
                DoctorLog::create($inputArray);
                break;
        }
    }

    /**
     * Summary of generateLoggedMessage
     * @param mixed $type
     * @param mixed $unit
     * @param mixed $unitName
     * @param mixed $columnName
     * @param mixed $old_data
     * @param mixed $new_data
     * @return string
     */
    private function generateLoggedMessage($type, $unit='', $unitName='', $columnName='', $old_data='', $new_data=''): string{
        $loggedInUser = $this->getLoggedInUser();
        $currentDate = Carbon::now()->format('jS \o\f M, Y \a\t g:i A');
        switch ($type){
            case 'add':
                return "New ".ucwords($unit)." added by ".ucwords($loggedInUser->name)." on ".$currentDate;
            case 'add_document':
                    return "New ".ucwords($unit).", ".$unitName." added by ".ucwords($loggedInUser->name)." on ".$currentDate;
            case 'update':
                return ucwords($columnName)." was updated from '".$old_data."' to '".$new_data."' by ".ucwords($loggedInUser->name)." on ".$currentDate;
            case 'active':
                return "The ".ucwords($unit).", ".$unitName." was Active by ".ucwords($loggedInUser->name)." on ".$currentDate;
            case 'inactive':
                return "The ".ucwords($unit).", ".$unitName." was Disable by ".ucwords($loggedInUser->name)." on ".$currentDate;
            default:
                return "";
        }
    }

    /**
     * Summary of getHumanReadableTime
     * @param mixed $dateTime
     * @return string
     */
    private function getHumanReadableTime($dateTime) {
        // Convert the input to a Carbon instance
        $providedTime = Carbon::parse($dateTime);
        $providedTimeDayStart = Carbon::parse($dateTime)->format('Y-m-d');
        $now = Carbon::now();
        // Calculate the difference in minutes, hours, and days
        $diffInMinutes = $now->diffInMinutes($providedTime);
        $diffInHours = $now->diffInHours($providedTime);
        $diffInDays = $now->diffInDays($providedTimeDayStart);
        
        // If the difference is less than 1 minute, return "just now"
        if ($diffInMinutes < 1) {
            return 'Just now';
        }

        // If the difference is less than 60 minutes, return the difference in minutes
        if ($diffInMinutes < 60) {
            return $diffInMinutes . ' minutes ago';
        }

        // If the difference is less than 2 days, return the difference in hours (to avoid rounding issues)
        if ($diffInHours < 48) {
            return $diffInHours . ' hours ago';
        }

        // If the difference is less than 7 days, return the difference in days
        if ($diffInDays < 7) {
            return $diffInDays . ' days ago';
        }

        // For dates older than 7 days, use Carbon's diffForHumans()
        return $providedTime->diffForHumans();
    }

    /**
     * Summary of getDoctorModalityList
     * @param mixed $doctor_id
     * @param mixed $returnArray
     * @return array|string
     */
    private function getDoctorModalityList($doctor_id, $returnArray = 1){
        $modalityList = DoctorModality::where('doctor_id', $doctor_id)
            ->where("status", '1')
            ->with('Modality')
            ->get();
        $modalityListArray = array();
        foreach($modalityList as $modality){
            $modalityListArray[] = $modality->Modality->name;
        }

        if($returnArray == 1){
            return $modalityListArray;
        }
        else{
            return implode(', ', $modalityListArray);
        }
    }

    /**
     * Summary of getLabModalityList
     * @param mixed $lab_id
     * @param mixed $returnArray
     * @return array|string
     */
    private function getLabModalityList($lab_id, $returnArray = 1){
        $modalityList = LabModality::where('laboratory_id', $lab_id)
            ->where("status", '1')
            ->with('Modality')
            ->get();
        $modalityListArray = array();
        foreach($modalityList as $modality){
            $modalityListArray[] = $modality->Modality->name;
        }

        if($returnArray == 1){
            return $modalityListArray;
        }
        else{
            return implode(', ', $modalityListArray);
        }
    }

    /**
     * Summary of generatePatientId
     * @param int $idLength
     * @return string
     */
    private function generatePatientId(int $idLength = 6){
        do {
            // Generate a numeric random string of the specified length
            $uniquePart = str_pad(random_int(0, pow(10, $idLength) - 1), $idLength, '0', STR_PAD_LEFT);
            $patientId = "QL-PT-" . $uniquePart;
        } while (Patient::where('patient_id', $patientId)->exists());
    
        return $patientId;
    }

    /**
     * Summary of generateCaseStudyId
     * @param int $idLength
     * @return string
     */
    private function generateCaseStudyId(int $idLength = 6){
        do {
            // Generate a numeric random string of the specified length
            $uniquePart = str_pad(random_int(0, pow(10, $idLength) - 1), $idLength, '0', STR_PAD_LEFT);
            $caseStudyId = "QL-CS-" . $uniquePart;
        } while (caseStudy::where('case_study_id', $caseStudyId)->exists());
    
        return $caseStudyId;
    }
}
