<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Member;
use App\Models\Event;
use App\Models\Attendance;
use Carbon\Carbon;
class AttendanceController extends Controller
{
   
    public function getDefaultAttendances (Request $request){

         $start_date = Carbon::now();
         $end_date = Carbon::now()->addMonths(2);
         $current_month = $start_date->format('m');
         $start_date = $start_date->format('Y-m');
         $end_date = $end_date->format('Y-m');
         $start_date = $start_date."-01";
         $end_date = $end_date."-01";
         Log::info($start_date);
         Log::info($end_date);
         $attendances = DB::select('select a.*, members.name,members.comment from (select event.meeting_date, event.title, attendances.* from (select * from events ORDER BY meeting_date) event LEFT JOIN attendances on event.id = attendances.event_id ORDER BY event.meeting_date) a LEFT JOIN members on a.name_id = members.id where a.meeting_date > ? and a.meeting_date < ? ORDER BY a.meeting_date',[$start_date,$end_date]);
         $members = Member::where(['del_flag'=>0])->get();
        //  $events = Event::where(['del_flag'=>0])->orderBy('meeting_date','ASC')->get();
         $events = DB::select('select * from events where meeting_date > ? and meeting_date < ? order by meeting_date',[$start_date,$end_date]);
          return response()->json([
              'attendances'=> $attendances,
              'members' => $members,
              'events' => $events,
              'current_month' => $current_month
          ]);
    }

    public function changeStatus(Request $request){
        $id = $request -> data["id"];
        $type = $request -> data["type"];
        $result = Attendance::where(['id'=>$id])->update(['attendance_type_id'=>$type]);
        return response()->json([
            'result'=> $type
        ]);
        
    }

    public function updateComment(Request $request){
        $comment = $request -> comment;
        $id = $request -> id;
        $result = Member::where(['id'=>$id])->update(['comment'=>$comment]);
        return response()->json([
            'result'=>'true'
        ]);

    }
}
