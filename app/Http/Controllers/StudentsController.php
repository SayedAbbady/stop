<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\Remember;
use App\Models\students;
use App\Models\newStudent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;

class StudentsController extends Controller
{

    public function index()
    {
        $user = Person::with('category')->orderBy('date','DESC')->paginate(50);

        return view('students.old.allstudents',[
            'users' => $user
        ]);

    }

    public function new_version()
    {

        $user = newStudent::with('category')->orderBy('date','DESC')->paginate(50);
        $cat = Category::all();

        return view('students.new.allstudents',[
            'users' => $user,
            "cat" => $cat,
            'cat_id' =>'all',
            'status_id' =>'all'
        ]);

    }

    public function create($id = null)
    {
        $teachers = Teacher::all();
        $cat = Category::all();
        return view('students.createstudents',[
            "cat" => $cat,
            "teachers" => $teachers
        ]);
    }

    public function convert($id)
    {
        $teachers = Teacher::all();
        $cat = Category::all();
        $user_data =  Person::where('id',$id)->get()->first();
        return view('students.convertstudents',[
            "cat" => $cat,
            "teachers" => $teachers,
            "user" => $user_data
        ]);

    }

    public function store_new_student(Request $request)
    {

        $request->validate([
            'category' => ['required'],
            'date' => ['required','date'],
            'parent_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:new_students'],

            'student' => "required|array",
            "student.*" =>   "required|string|distinct",

            'teacher' => "required|array",
            "teacher.*" =>   "required|string",

            'resone' => "required|array",
            "resone.*" =>   "required|string",

            'countChoosew' => ['required'],
            'phone' => ['required','numeric','unique:new_students'],
        ]);



        try {
            $user = newStudent::create([
                "parent_name"        =>$request->parent_name,
                "email"       =>$request->email,
                "phone"     => str_replace(' ','',$request->phone),
                "status"     => "1",
                "type"     => $request->category,
                "date"     => $request->date,
                "add_info"  => $request->Additional_info,

            ]);

            if ($user){


                $counti = $request->countChoosew;

                for ($i=0; $i < $counti; $i++) {
                //  echo $request->child."$i";

                    students::create([
                        "parent_id" => $user->id,
                        "name"      => $request->student[$i],
                        "teacher_id"      => $request->teacher[$i],
                        "resone"      => $request->resone[$i],
                        "hourrate"      => $request->hourrate[$i],
                        "lastsession"      => $request->lastdate[$i],
                    ]);
                }

                return response()->json([
                    "status"    => '1',
                    "msg"       => 'Added successfully ',
                ]);
            } else {

                return response()->json([
                    "status"    => '0',
                    "msg"       => 'Something is wrong please refresh page and try again'
                ]);
            }
        } catch (\Throwable $th) {
            return $th;
        }



    }

    public function convert_new_student(Request $request)
    {
        // return $request;
        $request->validate([
            'category' => ['required'],
            'parent_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:new_students'],

            'student' => "required|array",
            "student.*" =>   "required|string|distinct",

            'teacher' => "required|array",
            "teacher.*" =>   "required|string",

            'resone' => "required|array",
            "resone.*" =>   "required|string",

            'countChoosew' => ['required'],
            'phone' => ['required','numeric','unique:new_students'],
        ]);


        if ($request->has('result_info')){
            $request->validate([
                "result_info" => ['required']
            ]);
            $resy =  $request->result_info;
        } else {
            $resy =  null;
        }

        $shouldRemember = false;
        if ($request->has('alarm_date')){
            $request->validate([
                "alarm_date" => ['required'],
                "alarm_time" => ['required'],
                "note"       => ['nullable']
            ]);
            $shouldRemember = true;
        }



        try {
            $user = newStudent::create([
                "parent_name"       => $request->parent_name,
                "email"             => $request->email,
                "phone"             => str_replace(' ','',$request->phone),
                "status"            => $request->status,
                "type"              => $request->category,
                "date"              => $request->date,
                "responce"          => $resy,
                "add_info"          => $request->Additional_info,
            ]);

            if ($user){

                $counti = $request->countChoosew;

                for ($i=0; $i < $counti; $i++) {


                    students::create([
                        "parent_id" => $user->id,
                        "name"      => $request->student[$i],
                        "teacher_id"      => $request->teacher[$i],
                        "resone"      => $request->resone[$i],
                        "hourrate"      => $request->hourrate[$i],
                        "lastsession"      => $request->lastdate[$i],
                    ]);
                }

                if ($shouldRemember) {
                    Remember::create([
                        "date"          => $request->alarm_date,
                        "time"          => $request->alarm_time,
                        "admin_id"      =>Auth()->id(),
                        "student_id"    =>$user->id,
                        "note"          =>$request->note,
                        "action"        =>Null
                    ]);
                }


                Person::where('id',$request->parent_id)->delete();

                return response()->json([
                    "status"    => '1',
                    "msg"       => 'Added successfully ',
                ]);
            } else {

                return response()->json([
                    "status"    => '0',
                    "msg"       => 'Something is wrong please refresh page and try again'
                ]);
            }
        } catch (\Throwable $th) {
            return $th;
        }



    }

    public function show($id)
    {
        $user = newStudent::withTrashed()->with('category','remember_students','children')->find($id);
        if ($user) {

            return view('students.showOneStudent',[
                'user' => $user
            ]);
        } else {
            return redirect()->route('students.new');
        }
    }

    public function getBycategory (Request $request)
    {
        if ($request->category == 'all') {
            return redirect(route('students.new'));
        } else {

            $user = newStudent::with('category')->where('type',$request->category)->orderBy('date','DESC')->paginate(50);
            $cat = Category::all();


            return view('students.new.allstudents',[
                'users' => $user,
                "cat" => $cat,

                'status_id'=>'all',
                'cat_id'=>$request->category
            ]);
        }
    }

    public function getBystatus (Request $request)
    {
        if ($request->status == 'all') {
            return redirect(route('students.new'));
        } else {

            $user = newStudent::with('category')->where('status',$request->status)->orderBy('date','DESC')->paginate(50);
            $cat = Category::all();


            return view('students.new.allstudents',[
                'users' => $user,
                "cat" => $cat,
                'status_id'=>$request->status,
                'cat_id'=>'all'
            ]);
        }
    }

    public function edit($id)
    {

         $user = newStudent::where('id',$id)->with('children','remember_students')->get()->first();
        $teachers = Teacher::all();
        $cat = Category::all();
        return view('students.editstudents',[
            'user'=>$user,
            "cat" => $cat,
            "teachers" => $teachers,
        ]);
    }

    public function updateStudent(Request $request)
    {
        // return $request;
        $request->validate([
            'category' => ['required'],
            'parent_name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('new_students','email')->ignore($request->parent_id) ],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:new_students,email,'.request()->segment($request->parent_id).'.id'],

            'student' => "required|array",
            "student.*" =>   "required|string|distinct",

            'teacher' => "required|array",
            "teacher.*" =>   "required|string",

            'resone' => "required|array",
            "resone.*" =>   "required|string",

            'countChoosew' => ['required'],
            'phone' => ['required','numeric',Rule::unique('new_students','phone')->ignore($request->parent_id)],
        ]);


        if ($request->has('result_info')){
            $request->validate([
                "result_info" => ['required']
            ]);
            $resy =  $request->result_info;
        } else {
            $resy =  null;
        }
        $shouldRemember = false;
        if ($request->has('alarm_date')){
            $request->validate([
                "alarm_date" => ['required'],
                "alarm_time" => ['required'],
                "note"       => ['nullable']
            ]);
            $shouldRemember = true;
        }



        try {
            $user = newStudent::find($request->parent_id)->update([
                "parent_name"       => $request->parent_name,
                "email"             => $request->email,
                "phone"             => str_replace(' ','',$request->phone),
                "status"            => $request->status,
                "type"              => $request->category,
                "date"              => $request->date,
                "responce"          => $resy,
                "add_info"          => $request->Additional_info,
            ]);

            if ($user){

                $counti = $request->countChoosew;
                students::where('parent_id',$request->parent_id)->delete();

                for ($i=0; $i < $counti; $i++) {


                    students::create([
                        "parent_id" => $request->parent_id,
                        "name"      => $request->student[$i],
                        "teacher_id"      => $request->teacher[$i],
                        "resone"      => $request->resone[$i],
                        "hourrate"      => $request->hourrate[$i],
                        "lastsession"      => $request->lastdate[$i],
                    ]);
                }

                if ($shouldRemember) {
                    Remember::where([
                        ['student_id','=',$request->parent_id],
                        ['action','=',null]
                    ])->delete();

                    Remember::create([
                        "date"          => $request->alarm_date,
                        "time"          => $request->alarm_time,
                        "admin_id"      =>Auth()->id(),
                        "student_id"    =>$request->parent_id,
                        "note"          =>$request->note,
                        "action"        =>Null
                    ]);
                }


                return response()->json([
                    "status"    => '1',
                    "msg"       => 'Edit successfully ',
                ]);
            } else {

                return response()->json([
                    "status"    => '0',
                    "msg"       => 'Something is wrong please refresh page and try again'
                ]);
            }
        } catch (\Throwable $th) {
            return $th;
        }


    }

    public function deleted_students()
    {
        $user = newStudent::onlyTrashed()->with('category')->orderBy('date','DESC')->paginate(150);
        return view('students.deleted_students',[
            'users' => $user,
        ]);
    }

    public function restore(Request $request)
    {

        $sli = newStudent::withTrashed()->find($request->id)->restore();
        if ($sli) {
            students::withTrashed()->where('parent_id',$request->id)->restore();
            Remember::withTrashed()->where('student_id', $request->id)->restore();
            return response()->json([
                "status" => '1',
                "msg" => 'Restore successfully'
            ]);
        } else {
            return response()->json([
                "status" => '0',
                "msg" => 'Sorry, please try again'
            ]);
        }
    }

    public function force_Delete(Request $request)
    {

        $sliderDelete = newStudent::where('id',$request->id)->forceDelete();

        if ($sliderDelete) {
            students::where('parent_id', $request->id)->forceDelete();
            Remember::where('student_id', $request->id)->forceDelete();
            return response()->json([
                "status" => '1',
                "msg" => 'Deleted successfully'
            ]);
        } else {
            return response()->json([
                "status" => '0',
                "msg" => 'Sorry, please try again'
            ]);
        }
    }

    public function deletestudent(Request $request)
    {

        $sliderDelete = newStudent::destroy($request->id);

        if ($sliderDelete) {
            students::where('parent_id', $request->id)->delete();
            Remember::where('student_id', $request->id)->delete();
            return response()->json([
                "status" => '1',
                "msg" => 'Deleted successfully'
            ]);
        } else {
                return response()->json([
                    "status" => '0',
                    "msg" => 'Sorry, please try again'
                ]);
            }
    }
}

