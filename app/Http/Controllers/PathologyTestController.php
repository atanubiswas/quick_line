<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralFunctionTrait;
use Validator;
use DB;

use App\Models\Laboratory;
use App\Models\PathologyTest;
use App\Models\PathologyTestCategory;

class PathologyTestController extends Controller
{
    use GeneralFunctionTrait;
    private $pageName = "Pathology Test";
    
    public function addPathologyTest(){
        $pathologyCategory = PathologyTestCategory::all();
        
        return view("admin.addPathologyTest", ["pathologyCategory" => $pathologyCategory, "pageName" => $this->pageName]);
    }
    
    public function insertPathologyTest(Request $request){
        DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'test_name'       => 'required',
            'test_code'       => 'required',
            'pathology_test_categorie_id'   => 'required|numeric',
            'description'     => 'nullable',
            'price'           => 'required|numeric',
            'sample_type'     => 'required',
            'normal_range'    => 'nullable',
            'units'           => 'required',
            'turnaround_time' => 'nullable'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        
        try {
            PathologyTest::insert($request->all());
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
    
    public function viewPathologyTest() {
        $authUser = $this->getLoggedInUser();
        $pathologyTests = PathologyTest::with('pathlogyTestCategory')
                ->get();
        return view("admin.viewPathologyTest", ["pathologyTests" => $pathologyTests, "pageName" => $this->pageName, "authUser" => $authUser]);
    }
    
    public function addPathologyTestPackage(){
        $pathologyTests = PathologyTest::with('pathlogyTestCategory')
                ->get();
        return view("admin.addPathologyTestPackage", ["pathologyTests" => $pathologyTests, "pageName" => $this->pageName]);
    }
    
    /**
     * 
     * @param Request $request
     * @return JSON
     */
    public function getPathologyTest(Request $request){
        $validator = Validator::make($request->all(), [
            'laboratorie_id'=>'required|numeric|exists:laboratories,id',
            'search_text' => 'sometimes|nullable'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        $searchText = isset($request->search_text)?$request->search_text:"";
        $lab = Laboratory::find($request->laboratorie_id);
        $multiplier = 1 + ((float)$lab->income_percentge / 100);
        $pathologyTests = PathologyTest::selectRaw("test_name, test_code, description, sample_type, ROUND(price *".$multiplier.",2) as price")
            ->with('pathlogyTestCategory')
            ->when(!empty($searchText), function($query) use($searchText){
                $query->where("test_name", "like", "%".$searchText."%");
            })
            ->get();
        return $this->returnAPIResponse('Success', 200, $pathologyTests);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function editPathologyTest(Request $request) {
        $validator = Validator::make($request->all(), [
            'pathology_test_id' => 'required|numeric|exists:pathology_tests,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $pathologyTest = PathologyTest::where("id", $request->pathology_test_id)
                ->first();
        $pathologyCategory = PathologyTestCategory::all();
        return view("admin.editPathologyTest", ["pathologyTest" => $pathologyTest, "pathologyCategory" => $pathologyCategory,"pageName" => $this->pageName]);
    }

    public function updatePathologyTest(Request $request){
        $validator = Validator::make($request->all(), [
            'pthology_test_id' => 'required|numeric|exists:pathology_tests,id',
            'test_name'       => 'required',
            'test_code'       => 'required',
            'pathology_test_categorie_id'   => 'required|numeric',
            'description'     => 'nullable',
            'price'           => 'required|numeric',
            'sample_type'     => 'required',
            'normal_range'    => 'nullable',
            'units'           => 'required',
            'turnaround_time' => 'nullable'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
    }
}
