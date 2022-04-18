<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Event;
use App\Models\Attendance;
class AttendanceController extends Controller
{
   
    public function getDefaultAttendances (Request $request){
         $attendances = DB::select('select atten.*,members.name from (SELECT * from attendances where event_id in (select id from events) and name_id in (SELECT id from members)) atten LEFT JOIN members on atten.name_id = members.id 
         ');
         $members = Member::where(['del_flag'=>0])->get();
         $events = Event::where(['del_flag'=>0])->get();
          return response()->json([
              'attendances'=> $attendances,
              'members' => $members,
              'events' => $events
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
}
