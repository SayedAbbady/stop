<?php

namespace App\Http\Controllers;

use App\Models\Remember;
use Illuminate\Http\Request;

class RememberController extends Controller
{
    public function index () {

        $remember = Remember::with('admin','students_remember')->orderBy('date','ASC')->paginate(100);
        return view('remember.allremember',[ 
            'remember' => $remember 
        ]);
    }
    public function gotitshow () {

        $remember = Remember::where('action','!=',null)->with('admin','students_remember')->orderBy('date','ASC')->paginate(100);
        return view('remember.gotit',[
            'remember' => $remember
        ]);
    }
    public function noaction () {

        $remember = Remember::where('action',null)->with('admin','students_remember')->orderBy('date','ASC')->paginate(100);
        return view('remember.noaction',[
            'remember' => $remember
        ]);
    }

    public function gotit (Request $request) {

        $remember = Remember::where('id',$request->id)->update([
            'action'=>'Got it'
        ]);

        if ($remember) {

         return response()->json([
                "status"    => '1',
                "msg"       => "Update successfully"
            ]);
        } else {
            return response()->json([
                "status"    => '0',
                "msg"       => "something is wrong, please try again later"
            ]);
        }
    }
}
