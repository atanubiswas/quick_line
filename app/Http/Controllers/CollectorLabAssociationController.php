<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\CollectorLabAssociation;
use App\Traits\GeneralFunctionTrait;

class CollectorLabAssociationController extends Controller
{
    use GeneralFunctionTrait;
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function applyByCollector(Request $request){        
        $validator = Validator::make($request->all(), [
            'lab_id' => 'required|numeric|exists:laboratories,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        $collector = Auth::user()->getCollector()->first();
        $CollectorLabAssociation = new CollectorLabAssociation;
        $CollectorLabAssociation->laboratories_id = $request->lab_id;
        $CollectorLabAssociation->collector_id = $collector->id;
        $CollectorLabAssociation->save();
        
        return response()->json(['success' => [$this->getMessages('_STUPMSG')]]);
    }
    
    public function viewAppliedCollector(){
        $lab = Auth::user()->getLab()->first();
        
        CollectorLabAssociation::where("laboratories_id", $lab->id)
            ->where("status", "applied")
            ->update(["status"=>'processed']);
        $appliedCollectors = CollectorLabAssociation::selectRaw("*, CASE 
                WHEN status = 'applied' THEN 'bg-info'
                WHEN status = 'processed' THEN 'bg-warning'
                WHEN status = 'approved' THEN 'bg-success'
                WHEN status = 'rejected' THEN 'bg-danger'
                ELSE ''
            END AS button_type")
            ->where("laboratories_id", $lab->id)
            ->with('collector')
            ->get();
        $pageName = 'Collector';
        return view("admin.viewAppliedCollector", compact("appliedCollectors", "pageName"));
    }
    
    public function approveCollector(Request $request){
        $validator = Validator::make($request->all(), [
            'collector_id' => 'required|numeric|exists:collectors,id',
            'status'=> 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        $lab = Auth::user()->getLab()->first();
        CollectorLabAssociation::where("laboratories_id", $lab->id)
            ->where("collector_id", $request->collector_id)
            ->update(["status"=>$request->status]);
        return response()->json(['success' => [$this->getMessages('_STUPMSG')]]);
    }
}
