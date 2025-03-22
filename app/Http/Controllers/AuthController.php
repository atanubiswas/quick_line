<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

use App\Models\User;
use App\Models\role_user;
use App\Models\patient;

use App\Traits\GeneralFunctionTrait;


class AuthController extends Controller
{
    use GeneralFunctionTrait;
    
    /**
     * Summary of getToken
     * @param \App\Models\User $user
     * @param string $user_role
     * @param int $id
     * @param string $email
     * @param string $role
     * @return string
     */
    private function getToken(User $user, string $user_role, int $id, string $email, string $role):string{
        $token = $user->createToken('Personal Access Token', [
            'user_role:'.$user_role,
            'user_id:'.$id,
            'user_email:'.$email,
            'user_role_name:'.$role
        ])->plainTextToken;
        
        return $token;
    }
    
    /**
     * Summary of adminLoginView
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminLoginView(Request $request){
        $r = isset($request->r)?$request->r:"";
        return view("admin.login", ["r" => $r]);
    }
    
    /**
     * Summary of adminLogin
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function adminLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        
        $hasUser = User::where("email", strtolower($request->email))
            ->first();

        if(!$hasUser){
            return redirect()->route('admin.login')->with('error', 'Login Email Not Found.');
        }
        if($hasUser->status != 1){
            return redirect()->route('admin.login')->with('error', 'Your account is Deactivated, Contact Quick Line Team to Re-active.');
        }
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            //$user->increment("login_count");
            if($user->is_first_login == 1){
                return redirect()->intended(url("/admin/change-password"));
            }
            $r = empty($request->r)?url("/admin/dashboard"):$request->r;
            return redirect()->intended($r);
        }
        return redirect()->route('admin.login')->with('error', 'Invalid Credentials');
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function getAccessToken(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'user_role' => ['required', Rule::in(['admin', 'collector','doctor','laboratory','manager','supar_admin','user'])]
            ]);
            if (!$validator->passes()) {
                return $this->validationErrorResponse($validator->errors());
            }
            $user = User::selectRaw("users.id, users.name, password, email, mobile_number, last_login_at, user_image, roles.name as user_role")
                ->leftJoin("role_users", "users.id", "=", "role_users.user_id")
                ->leftJoin("roles", "role_users.role_id", "roles.id")
                ->where('email', $request->email)
                ->where("roles.name", $request->user_role)
                ->first();
            
            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->returnAPIResponse('Error', 401, 'The provided credentials are incorrect.');
            }
            
            $token = $this->getToken($user, $request->user_role, $user->id, $user->email, $user->user_role);
            
            return $this->returnAPIResponse('Success', 200, ['access_token'=>$token, 'user_data'=>$user]);
        }
        catch(Exception $e){
            $msg = $e->getMessage();
            return $this->returnAPIResponse('Error', 500, $msg);
        }
    }
    
    /**
     * 
     * @return type
     */
    public function logout(){
        Auth::logout();
        return redirect('/admin');
    }
    
    public function userLoginorRegister(Request $request) {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required'
        ]);
        if (!$validator->passes()) {
            return $this->validationErrorResponse($validator->errors());
        }
        try{
            $mobile = $this->formatMobileNumber($request->mobile);
            $userImage =  asset('images/default.png');
            $user = User::selectRaw("users.id, users.name, password, email, mobile_number, last_login_at, user_image, roles.name as user_role")
                ->leftJoin("role_users", "users.id", "=", "role_users.user_id")
                ->leftJoin("roles", "role_users.role_id", "roles.id")
                ->where('mobile_number', $mobile)
                ->where("roles.name", 'user')
                ->first();

            $email = '';
            if(!$user){
                // USER IS NOT PRESENT CREATE NEW USER
                $user = new User;
                $user->name = 'New User';
                $user->email = $mobile;
                $user->password = Hash::make($this->generateRandomPassword(5));
                $user->mobile_number = $mobile;
                $user->user_image = $userImage;
                $user->save();

                $role_user = new role_user;
                $role_user->role_id = 7;
                $role_user->user_id = $user->id;
                $role_user->save();

                $email = $mobile;
                
                $patient = new patient;
                $patient->first_name = 'New';
                $patient->last_name = 'User';
                $patient->full_name = 'New User';
                $patient->email = $mobile;
                $patient->mobile_number = $mobile;
                $patient->address = "New Address";
                $patient->user_id = $user->id;
                $patient->save();
            }
            else{
                $email = $user->email;
            }

            $accessToken = $this->getToken($user, 'user', $user->id, $email, 7);
            return $this->returnAPIResponse('Success', 200, ['access_token'=>$accessToken, 'user_data'=>$user]);
        }
        catch(Exception $e){
            return $this->returnAPIResponse('Error', 500, $e->getMessage());
        }
        catch(QueryException $e){
            return $this->returnAPIResponse('Error', 500, $e->getMessage());
        }
    }
    
    /**
     * 
     * @param Request $request
     * @return JSON
     */
    public function updatePatientProfile(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile_number' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
        ]);
        if (!$validator->passes()) {
            return $this->validationErrorResponse($validator->errors());
        }
        
        try{
            $auth = Auth::user();
            if(trim(strtolower($auth->email)) !== trim(strtolower($request->email)) && $this->checkDuplicate('users', 'email', $request->email)){
                return $this->returnAPIResponse('Error', 200, "Email already exist."); 
            }
            if(trim(strtolower($auth->mobile_number)) !== trim($this->formatMobileNumber($request->mobile_number)) && $this->checkDuplicate('users', 'mobile_number', $request->mobile_number)){
                return $this->returnAPIResponse('Error', 200, "Mobile Number already exist."); 
            }
            $dob = Carbon::parse($request->date_of_birth);
            $formatted_dob = $dob->format('Y-m-d');
            $mobile = $this->formatMobileNumber($request->mobile_number);
            
            $patient = patient::where("user_id", $auth->id)->first();
            $patient->first_name = $request->first_name;
            $patient->last_name = $request->last_name;
            $patient->full_name = $request->first_name." ".$request->last_name;
            $patient->email = $request->email;
            $patient->mobile_number = $mobile;
            $patient->date_of_birth = $formatted_dob;
            $patient->gender = $request->gender;
            $patient->address = $request->address;
            $patient->city = $request->city;
            $patient->state = $request->state;
            $patient->country = $request->country;
            $patient->postal_code = $request->postal_code;
            $patient->save();
            
            $user = user::find($auth->id);
            $user->name = $request->first_name." ".$request->last_name;
            $user->email = $request->email;
            $user->mobile_number = $mobile;
            $user->save();
            return $this->returnAPIResponse('Success', 200, "User Data Updated");
        } catch(Exception $e){
            return $this->returnAPIResponse('Error', 500, $e->getMessage());
        }
        catch(QueryException $e){
            return $this->returnAPIResponse('Error', 500, $e->getMessage());
        }
    }
}
