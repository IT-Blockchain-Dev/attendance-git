<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Member;
use App\Models\Attendance;
class EventController extends Controller
{
    //

    public function add(Request $request){
        $event_info = $request ->event_info;
        $result = Event::create([
            'title'=>$event_info['title'],
            'detail'=>$event_info['detail'],
            'meeting_date'=>$event_info['date'],
            'meeting_time'=>$event_info['event'],
        ]);
        $new_event_id = $result->id;
        $all_members = Member::where(['del_flag'=>0])->get();
        foreach($all_members as $member){
               Attendance::create([
                   'name_id'=>$member['id'],
                   'event_id'=>$new_event_id,
                   'attendance_type_id'=>'0'
               ]);
        }
        $result1 = Event::where(['del_flag'=>0])->get();
        return response()->json([
            'result'=>$result1
        ]);

    }

    public function get(Request $request){
        $result = Event::where(['del_flag'=>0])->get();
        return response()->json([
            'result'=>$result
        ]);
    }

    public function delete(Request $request){
        $id = $request -> id;
        $result = Event::where([
            'id'=> $id
        ]) -> delete();

        $result = Event::where(['del_flag'=>0])->get();
        return response()->json([
            'result'=>$result
        ]);

    }

    public function update(Request $request){
        $update_event = $request -> update_event;
        $result = Event::where(['id'=> $update_event['id']])->
        update(['title'=>$update_event['title'],'detail'=>$update_event['detail'],
        'meeting_time'=> $update_event['event']]);
        $result1 =Event::where(['del_flag'=>0])->get();
        return response()->json([
            'result'=> $result1
        ]);
    }
}
