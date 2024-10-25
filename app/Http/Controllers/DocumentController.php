<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\role_user;
use App\Models\Collector;
use App\Models\Laboratory;
use App\Models\userDocument;

use App\Traits\GeneralFunctionTrait;

class DocumentController extends Controller {
    
    use GeneralFunctionTrait;
    private $pageName = "Documents";
    
    /**
     * Summary of addDocument
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addDocument(){
        return view("admin.addDocument", ["pageName" => $this->pageName]);
    }

    /**
     * Summary of addDocumentAjax
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addDocumentAjax(Request $request){
        $labratory = Laboratory::find($request->lab_id);
        return view("admin.addDocumentAjax", ["pageName" => $this->pageName, "labratory"=> $labratory]);
    }
    
    /**
     * Summary of uploadDocument
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function uploadDocument(Request $request) {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'user_id'   => 'required',
                'document_type' => 'required',
                'document_number' => 'required',
                'document_front_image' => 'required|file|mimes:jpg,jpeg,png',
                'document_back_image' => 'nullable|file|mimes:jpg,jpeg,png',
                'document_start_date' => 'nullable|date_format:d/m/Y|before:today',
                'document_end_date' => 'nullable|date_format:d/m/Y|after:today',
            ]);
            if (!$validator->passes()) {
                return response()->json(['error' => $validator->errors()]);
            }
            /*========== CODE FOR GETTING THE CLIENT TYPE ===============*/
            $userType = role_user::select('roles.name', DB::raw('users.name as user_name'))
                ->leftJoin('roles', 'roles.id', '=', 'role_users.role_id')
                ->leftJoin('users','users.id','=','role_users.user_id')
                ->where("role_users.user_id", $request->user_id)
                ->first();
                
            /*========== CODE FOR GETTING THE CLIENT TYPE ===============*/
            $document_front_image_path = $document_back_image_path = null;
            $uploadPath = 'uploads'. DIRECTORY_SEPARATOR . $userType->name . DIRECTORY_SEPARATOR;
            $file = $request->file('document_front_image');
            $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($uploadPath . str_replace(" ", "_", $userType->user_name)), $imageName);
            $document_front_image_path = $uploadPath . str_replace(" ", "_", $userType->user_name) . '/' . $imageName;
            
            if ($request->hasFile('document_back_image')) {
                $backFile = $request->file('document_back_image');
                $backImageName = uniqid() . '.' . $backFile->getClientOriginalExtension();
                $backFile->move(public_path($uploadPath . str_replace(" ", "_", $userType->user_name)), $backImageName);
                $document_back_image_path = $uploadPath . str_replace(" ", "_", $userType->user_name) . '/' . $backImageName;
            }
            $userDocument = new userDocument;
            $userDocument->document_type = $request->document_type;
            $userDocument->document_number = $request->document_number;
            $userDocument->document_front_image = $document_front_image_path;
            $userDocument->document_back_image = $document_back_image_path;
            $userDocument->document_start_date = empty($request->document_start_date)?NULL:Carbon::createFromFormat('d/m/Y', $request->document_start_date)->format('Y/m/d');
            $userDocument->document_end_date = empty($request->document_end_date)?NULL:Carbon::createFromFormat('d/m/Y', $request->document_end_date)->format('Y/m/d');
            $userDocument->status = 1;
            $userDocument->approved_on = Carbon::now()->toDateTimeString();
            $userDocument->approved_by = Auth::user()->id;
            $userDocument->user_id = (int) $request->user_id;
            $userDocument->save();

            $msg = $this->generateLoggedMessage("add_document", "Document", $request->document_type);
            $this->addLog("laboratory", "laboratorie_id", $request->lab_id, "add", $msg);
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
     * Summary of viewDocument
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewDocument() {
        $documents = userDocument::selectRaw("user_documents.*, case when user_documents.status=0 THEN \"Not Verified\" WHEN user_documents.status=1 THEN \"Approved\" ELSE \"Rejected\" END as doc_status, case when document_start_date is NULL THEN \"N/A\" ELSE DATE_FORMAT(user_documents.document_start_date, '%D of %M, %Y') END as st_dt, case when document_end_date is NULL THEN \"N/A\" ELSE DATE_FORMAT(user_documents.document_end_date, '%D of %M, %Y') END as en_dt")
                ->where('user_id', Auth::user()->id)
                ->get();
        return view("admin.viewDocuments", ["documents" => $documents, "pageName" => " View ".$this->pageName]);
    }
    
    public function getDocuments(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        
        switch($request->type){
            case 'collector':
                $user = Collector::find($request->id);
                $user_name = $user->collector_name;
                break;
            
            case 'centre':
                $user = Laboratory::find($request->id);
                $user_name = $user->lab_name;
                break;
        }
        
        $documents = userDocument::selectRaw("user_documents.*, case when user_documents.status=0 THEN \"Not Verified\" WHEN user_documents.status=1 THEN \"Approved\" ELSE \"Rejected\" END as doc_status, case when document_start_date is NULL THEN \"N/A\" ELSE DATE_FORMAT(user_documents.document_start_date, '%d-%m-%Y') END as st_dt, case when document_end_date is NULL THEN \"N/A\" ELSE DATE_FORMAT(user_documents.document_end_date, '%d-%m-%Y') END as en_dt")
            ->where('user_id', $user->user_id)
            ->get();
        return view("admin.approve_documents", ["documents" => $documents, "user_name" => $user_name,"pageName" => " View ".$this->pageName]);
    }
    
    /**
     * Summary of updateDocumentStatus
     * @param \Illuminate\Http\Request $request
     * @return bool|mixed|\Illuminate\Http\JsonResponse
     */
    public function updateDocumentStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'document_id' => 'required|numeric|exists:user_documents,id',
            'status' => 'required|numeric'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        
        $document = userDocument::find($request->document_id);
        $document->status = $request->status;
        $document->approved_by = Auth::user()->id;
        $document->approved_on = Carbon::now();
        $document->save();
        return true;
    }
}
