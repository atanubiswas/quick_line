<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\role_user;

class RoleController extends Controller
{
    public function getUserByRole(Request $request){
        $validator = Validator::make($request->all(), [
            'role_id' => 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        $roleId = $request->role_id;
        $users = role_user::where("role_id", $roleId)
            ->with("user")
            ->get();
        return view("admin.generate_user_options", ["users" => $users]);
    }
}
