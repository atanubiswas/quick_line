<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;

use App\Models\Notification;
use App\Models\role;
use App\Models\User;
use App\Models\role_user;

use App\Traits\GeneralFunctionTrait;
class NotificationController extends Controller
{
    use GeneralFunctionTrait;
    private $pageName = "Noification";
    
    private function getUsers($notification_for, $users){
        $user_ids = array();
        $rold_id = 0;
        if(trim(strtolower($notification_for)) != 'all'){
            $user_ids = role_user::where("role_id", $notification_for)
                ->pluck("user_id")
                ->toArray();
        }
        else{
            $user_ids = role_user::where("role_id", "!=", 1)
                ->pluck("user_id")
                ->toArray();
        }
        if(trim(strtolower($users)) != 'all'){
            $user_ids = array($users);
        }
        
        $users = User::when(count($user_ids) > 0, function($query) use($user_ids){
            $query->whereIn("id", $user_ids);
        })
            ->get();
        return $users;
    }
    
    /*================== STARTING OF PUBLIC FUNCTIONS ====================*/
    /**
     * 
     * @return type
     */
    public function addNotification(){
        $roles = role::where("id", "!=", 1)
            ->orderBy('name')
            ->get();
        return view("admin.addNotification", ["pageName" => $this->pageName, "roles" => $roles]);
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function insertNotification(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'notification' => 'required',
                'notification_for' => 'required',
                'select_user' => 'required'
            ]);
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()]);
            }

            $users = $this->getUsers($request->notification_for, $request->select_user);
            $Auth = Auth::user();
            
            foreach($users as $user){
                $notification = new Notification;
                $notification->notification = $request->notification;
                $notification->user_id = $user->id;
                $notification->notification_type = "text";
                $notification->notification_time = Carbon::now()->toDateTimeString();
                $notification->added_by = $Auth->id;
                $notification->status = 1;
                $notification->save();
            }
            return response()->json(['success' => [$this->getMessages('_SVSUMSG')]]);
        }
        catch(\Exception $ex){
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
    }
}
