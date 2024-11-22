<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\Doctor;
use App\Models\DoctorLog;
use App\Models\Laboratory;
use App\Models\laboratoryLog;

use App\Traits\GeneralFunctionTrait;

class TimeLineController extends Controller
{
    use GeneralFunctionTrait;


    /**
     * Summary of getTimeLine
     * @param mixed $model
     * @param mixed $column_name
     * @param mixed $element_id
     * @return mixed
     */
    private function getTimeLine($model, $column_name, $element_id){
        $timeLines = $model::selectRaw("*, date(created_at) as created_at_date, 
        case when 
            `type`='add' then 'fas fa-file-import' when 
            `type` = 'update' then 'fas fa-edit' when 
            `type` = 'delete' then 'fas fa-times-circle' when
            `type` = 'active' then 'fa fa-play' when
            `type` = 'inactive' then 'fa fa-pause'
        end as icon, 
        case when 
            `type`='add' then 'bg-success' when 
            `type` = 'update' then 'bg-warning' when 
            `type` = 'delete' then 'bg-danger' when
            `type` = 'active' then 'bg-success' when
            `type` = 'inactive' then 'bg-danger'
        end as icon_color, 
        case when 
            `type`='add' then 'Added an Item' when 
            `type` = 'update' then 'Update an Item' when 
            `type` = 'delete' then 'Deleted an Item' when
            `type` = 'active' then 'Active an Item' when
            `type` = 'inactive' then 'Inactive an Item'
        end as min_text")
            ->where($column_name, $element_id)
            ->with('users')
            ->orderBy('created_at', 'desc')
            ->get();

        return $timeLines;
    }
    /**
     * Summary of getLabTimeline
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function getLabTimeline(Request $request){
        $validator = Validator::make($request->all(), [
            'lab_id' => 'required|numeric|exists:laboratories,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $labratory = Laboratory::find($request->lab_id);
        $element_name = $labratory->lab_name;
        $timeLines = $this->getTimeLine(laboratoryLog::class, 'laboratorie_id', $request->lab_id);

        foreach($timeLines as $timeLine) {
            $eventTime = $this->getHumanReadableTime($timeLine->created_at);
            $timeLine->event_time = $eventTime;
        }

        return view("admin.viewTimeline", compact("timeLines", "element_name"));
    }

    public function getDocTimeline(Request $request){
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|numeric|exists:doctors,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $doctor = Doctor::find($request->doctor_id);
        $element_name = $doctor->name;
        $timeLines = $this->getTimeLine(DoctorLog::class, 'doctor_id', $request->doctor_id);

        foreach($timeLines as $timeLine) {
            $eventTime = $this->getHumanReadableTime($timeLine->created_at);
            $timeLine->event_time = $eventTime;
        }

        return view("admin.viewTimeline", compact("timeLines", "element_name"));
    }
}
