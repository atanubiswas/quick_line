<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\Laboratory;
use App\Models\laboratoryLog;

use App\Traits\GeneralFunctionTrait;

class TimeLineController extends Controller
{
    use GeneralFunctionTrait;

    /**
     * Summary of getLabTimeline
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function getLabTimeline(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lab_id' => 'required|numeric|exists:laboratories,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $labratory = Laboratory::find($request->lab_id);

        $timeLines = laboratoryLog::selectRaw("*, date(created_at) as created_at_date, 
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
            ->where('laboratorie_id', $request->lab_id)
            ->with('users')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach($timeLines as $timeLine) {
            $eventTime = $this->getHumanReadableTime($timeLine->created_at);
            $timeLine->event_time = $eventTime;
        }

        return view("admin.viewTimeline", compact("timeLines", "labratory"));
    }
}
