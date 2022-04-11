<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    //
    public function add(Request $request){
         $user = $request -> user;
         $result = Member::create([
               'name' => $user['name'],
               'memo' => $user['memo']
         ]);

         $result = Member::where(['del_flag'=>0])->get();
         return response()->json([
             'result'=>$result
         ]);
        
    }

    public function get(Request $request){
        $result = Member::where(['del_flag'=>0])->get();
        return response()->json([
            'result'=>$result
        ]);
    }

    public function delete(Request $request){
        $id = $request -> id;
        $result = Member::where([
              'id' => $id
        ])->delete();

        $result = Member::where(['del_flag'=>0])->get();
        return response()->json([
            'result'=>$result
        ]);
       
   }

   public function update(Request $request){
        $user = $request ->user;
        $result = Member::where(['id'=>$user['id']])->
        update(['name'=>$user['name'],'memo'=>$user['memo']]);
        
        $result = Member::where(['del_flag'=>0])->get();
        return response()->json([
            'result'=>$result
        ]);


   }
}
