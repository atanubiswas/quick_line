<?php

namespace App\Http\Controllers;

use App\Traits\GeneralFunctionTrait;
use Illuminate\Http\Request;
use Validator;
use DB;

use App\Models\User;
use App\Models\role;
use App\Models\role_user;

class UserController extends Controller
{
    use GeneralFunctionTrait;
    private $pageName = "Users";

    /**
     * Summary of addUser
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addUser(Request $request){
        $roles = role::whereIn("id", array(2, 5))->orderBy("name")->get();
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
            $user->email = $request->input('user_login_email');
            $user->password = bcrypt($request->input('password'));
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
        $users = User::with('roles')
            ->whereIn("access_type", array('Quality Controller', 'Manager'))
            ->get();
        $pageName = $this->pageName;
        return view("admin.viewUsers", compact("users", "pageName"));
    }
}
