<?php

namespace App\Http\Controllers;

use App\Traits\GeneralFunctionTrait;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

use App\Models\User;
use App\Models\role;
use App\Models\role_user;

class UserController extends Controller
{
    use GeneralFunctionTrait;
    private $pageName = "Users";
    private $defaultPassword = "Quick Line";

    /**
     * Summary of addUser
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addUser(Request $request){
        $auth = Auth::user();
        $roleArray = $auth->roles[0]->name === 'Manager'?array(2):array(2,5);
        $roles = role::whereIn("id", $roleArray)->orderBy("name")->get();
        return view("admin.addUser", ["pageName" => $this->pageName, "roles"=> $roles]);
    }

    /**
     * Summary of insertUser
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function insertUser(Request $request){
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'user_name'   => 'required',
                'user_login_email' => 'required|email|unique:users,email',
                'user_phone_number' => 'required',
                'user_type' => 'required|integer|exists:roles,id',
            ]);
            if (!$validator->passes()) {
                return response()->json(['error' => $validator->errors()]);
            }

            $role = role::where('id', $request->input('user_type'))->first();
            $user = new User();
            $user->name = $request->input('user_name');
            $user->email = strtolower($request->input('user_login_email'));
            $user->password = bcrypt($this->defaultPassword);
            $user->access_type = $role->name;
            $user->mobile_number = $request->input('user_phone_number');
            $user->user_image = $this->getUserImage($request->input('user_name'));
            $user->save();
            $userId = $user->id;
            
            $roleUser = new role_user;
            $roleUser->role_id = $request->input('user_type');
            $roleUser->user_id = $userId;
            $roleUser->save();
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
     * Summary of viewUser
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewUser(){
        $authUser = Auth::user();
        $users = User::with('roles')
            ->whereIn("access_type", array('Quality Controller', 'Manager'))
            ->get();
        $pageName = $this->pageName;
        return view("admin.viewUsers", compact("users", "pageName", "authUser"));
    }
    
    /**
     * Summary of changePassword
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function changePassword(Request $request){
        $r = isset($request->r)?$request->r:"";
        return view("admin.changePassword", ["pageName" => $this->pageName, "r" => $r]);
    }

    /**
     * Summary of updatePassword
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request){
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->is_first_login = '0';
        $user->save();

        $r = empty($request->r)?"/admin/dashboard":$request->r;
        return redirect()->intended($r);
    }

    /**
     * Summary of changeStatus
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request){
        $request->validate([
            'user_id' => 'required|integer|exists:users,id'
        ]);
        
        $status = ($request->is_checked=='true') ?1:0;
        User::where('id', $request->user_id)->update(['status'=> $status]);
        return response()->json(['success' => [$this->getMessages('_UPSUMSG')]]);
    }
}
