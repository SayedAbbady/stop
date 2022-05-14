<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\Remember;
use App\Models\students;
use App\Models\newStudent;
use Illuminate\Http\Request;
use App\Imports\TeachersImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;



class HomeController extends Controller
{

    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        // make chart js for stop students according to date
        $users = newStudent::select('date')
        ->where( DB::raw('YEAR(date)'), '=', Carbon::parse($today)->format('Y') )
        ->get()
        ->groupBy(function($date) {
            //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            return Carbon::parse($date->date)->format('m'); // grouping by months
        });

        $usermcount = [];
        $userArr = [];

        foreach ($users as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($usermcount[$i])){
                $userArr[$i] = $usermcount[$i];
            }else{
                $userArr[$i] = 0;
            }
        }

        $remember = Remember::where('date',$today)->with('admin','students_remember')->orderBy('time','ASC')->get();

        $teacher_graph = Teacher::select('name')->withCount('students')->get();
        $teacher_name =[];
        $teacher_count =[];
        foreach ($teacher_graph as $value) {
            array_push($teacher_name,$value->name);
            array_push($teacher_count,$value->students_count);
        }



        return view('home',[
            'catnum'        => Category::count(),
            'studentnum'    => newStudent::count(),
            'childnum'      => students::count(),
            'teachernum'      => Teacher::count(),
            'allarmnum'      => Remember::where('action',null)->count(),
            'remember'      => $remember,
            'userArr'       =>json_encode(array_values($userArr)),
            'teacher_name'       =>json_encode(array_values($teacher_name)),
            'teacher_count'       =>json_encode(array_values($teacher_count))
        ]);
    }

    public function get_graph(Request $request)
    {
        $users = Person::select('date')
        ->where( DB::raw('YEAR(date)'), '=', $request->year )
        ->get()
        ->groupBy(function($date) {
            //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            return Carbon::parse($date->date)->format('m'); // grouping by months
        });
        $usermcount = [];
        $userArr = [];

        foreach ($users as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($usermcount[$i])){
                $userArr[$i] = $usermcount[$i];
            }else{
                $userArr[$i] = 0;
            }
        }

        return response()->json([
            "status"    => '1',
            "msg"       => array_values($userArr),
        ]);
    }

    public function teachers ()
    {

        $teachers = Teacher::withCount('students')->orderBy('id',"DESC")->paginate(50);
        return view('teachers.allteachers',[
            'teachers' => $teachers
        ]);
    }

    public function teachers_get_students (Request $request)
    {
        $teachers = students::where('teacher_id',$request->id)->with('parent')->get();

        $de = "
            <table class='table table-striped table-bordered table-hover'>
                    <thead>
                        <tr>
                        <th scope='col'>#</th>
                        <th scope='col' class='bg-primary text-white'>Student name </th>
                        <th scope='col' class='bg-danger text-white'>Parent name</th>
                        <th scope='col' class='bg-success text-white'>Stop resone</th>
                        </tr>
                    </thead>
                    <tbody>
              ";
    $id = 1;
        foreach ($teachers as $item) {
            $de .= "
                <tr>
                    <td>".$id++."</td>
                    <td>".$item->name."</td>
                    <td><a href=".route('students.show',$item->parent->id).">".$item->parent->parent_name."</td>
                    <td>".$item->resone."</td>

                </tr>
            ";
        }

        $de .= "
                </tbody>
                </table>
        ";

        return response()->json([
            "status"    => '1',
            "msg"       => $de
        ]);
    }

    public function add_teachers ()
    {
        return view('teachers.createteachers');
    }

    public function add_teachers_ajax(Request $request)
    {
        $request->validate([

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required','numeric'],
        ]);
        $user = Teacher::create([
            "name"        =>$request->name,
            "email"       =>$request->email,
            "phone"     => $request->phone,

        ]);

        if ($user){
            return response()->json([
                "status"    => '1',
                "msg"       => 'Added successfuly',
            ]);
        } else {

            return response()->json([
                "status"    => '0',
                "msg"       => 'Something is wrong please refresh page and try again'
            ]);
        }

    }

    public function upload_file ()
    {
        Excel::import(new TeachersImport,request()->file('file'));
        return  redirect()->route('teachers.index')->with([
                "status"    => '1',
                "msg"       => 'Imported data successfully'
            ]);
    }

    public function deleteTeacher (Request $request)
    {
        $sliderDelete = Teacher::destroy($request->id);

        if ($sliderDelete)
            return response()->json([
                "status"    => '1',
                "msg"       => 'Deleted successfully'
            ]);
        else
            return response()->json([
                "status"    => '0',
                "msg"       => 'Sorry, please try again'
            ]);
    }

    public function history(Request $request)
    {
        if ($request->type == 'user') {
            // return data when user click to know what user do
            $activity = Activity::where('causer_id',$request->id)->orderBy('id','DESC')->paginate(150);

            return view('historyusers',[
                'user'      =>User::where('id',$request->id)->get()->first(),
                'activity'  => $activity
            ]);
        } else {
            // return activity for students , categories and everything depends on type and id form get request
            $activity =  Activity::with('subject','causer')->where([
                ['log_name','=',$request->type],
                ['subject_id','=',$request->id]
                ])->orderBy('id','DESC')->paginate(150);

            return view('history',[
                'activity' => $activity
            ]);

        }
        return 'false';
    }

    public function history_getdetails(Request $request)
    {
        // return $request->type;
        /**
         * when user clcik on show details btn in historyusers view what data will returned
         *
         */
        $sliderDelete = Activity::where('id',$request->id)->get()->first();

        if ($request->type == 'delete_category') {

            $val = $sliderDelete->properties['attributes']['name'];
            $de = "<b>Category was delete:</b> <br>". $val ."";

            return response()->json([
                "status"    => '1',
                "msg"       => $de
            ]);
        } else if ($request->type == 'delete_students') {
            $val_id = $sliderDelete->properties['attributes']['id'];
            $val = $sliderDelete->properties['attributes']['parent_name'];
            $val2 = $sliderDelete->properties['attributes']['email'];
            $val3 = $sliderDelete->properties['attributes']['phone'];
            $de = "<b>Family was delete:</b> <br><br>
            <b>Parent name:</b> $val<br>
            <b>Email:</b> $val2<br>
            <b>Phone:</b> $val3<br>
            <br>
            <button type='button' class='btn btn-success restorDa '>
                Restore
            </button>
            <script>
                $('.restorDa').on('click',function(e){
                    e.preventDefault();
                    Swal.fire({
                        icon: 'question',
                        title: 'Are you sure ?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',

                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                            url: link+'/students/restore',
                            method: 'get',
                            data: {
                                'id': $val_id,
                            },

                            success: function (data) {
                                if (data.status == '1'){
                                Swal.fire({
                                    title: 'Done !',
                                    text: data.msg,
                                    icon: 'success',
                                    padding: '2em'
                                })
                                }
                            },

                            })
                        }});

                });
            </script>
            ";

            return response()->json([
                "status"    => '1',
                "msg"       => $de
            ]);
        } else if ($request->type == 'updated') {
            $val = $sliderDelete->changes();

            $de = '<table class="table table-striped table-bordered table-hover table-responsive ">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="bg-primary text-white">Target </th>
                        <th scope="col" class="bg-danger text-white">Old Value </th>
                        <th scope="col" class="bg-success text-white">New value</th>
                        </tr>
                    </thead>
                    <tbody>';
            $counter=1;
            foreach($val['old'] as $attribute => $old) {
                if($attribute == "status") {
                    switch ($old) {
                    case "2":
                        $old = "Contact";
                        break;
                    case "3":
                        $old = "Alarm";
                        break;
                    case "4":
                        $old = "Contact and no answer";
                        break;

                    default:
                        $old = "No contact";
                    }
                    $bb = $val['attributes'][$attribute];
                    switch ($bb) {
                    case "2":
                        $bb = "Contact";
                        break;
                    case "3":
                        $bb = "Alarm";
                        break;
                    case "4":
                        $bb = "Contact and no answer";
                        break;

                    default:
                        $bb = "No contact";
                    }
                    $de.= "<tr>
                        <th scope='row'>". $counter++ ."</th>
                        <td><b>$attribute</b></td>
                        <td>$old</td>
                        <td>".$bb."</td>
                        </tr>";
                } elseif ($attribute == "type") {
                    $cat_name =  Category::select('name')->where('id',$old)->get()->first()->name;
                    $bb = $val['attributes'][$attribute];
                    $cat_name2 =  Category::select('name')->where('id',$bb)->get()->first()->name;
                    $de.= "<tr>
                        <th scope='row'>". $counter++ ."</th>
                        <td><b>Category</b></td>
                        <td>$cat_name </td>
                        <td>".$cat_name2."</td>
                        </tr>";
                } else {
                        $de.= "<tr>
                        <th scope='row'>". $counter++ ."</th>
                        <td><b>$attribute</b></td>
                        <td>$old</td>
                        <td>".$val['attributes'][$attribute]."</td>
                        </tr>";
                }



            }

            $de .= "</tbody>
                    </table>
                    ";
                    // <br>
                    // <br>
                    // <a class='btn btn-primary' href=>Show information</a>
            return response()->json([
                "status"    => '1',
                "msg"       => $de
            ]);
        } else {
            return response()->json([
                "status"    => '0',
                "msg"       => "something is wrong, please try again later"
            ]);
        }



    }

    public function search(Request $request)
    {

        $request->validate([
            'searchtext' => ['required'],
        ]);

        $students = newStudent::where('parent_name', 'LIKE', "%{$request->searchtext}%")
            ->orWhere('email', 'LIKE', "%{$request->searchtext}%")
            ->orWhere('phone', 'LIKE', "%{$request->searchtext}%")

            ->with('category')->get();


        $teachrs = Teacher::where('name', 'LIKE', "%{$request->searchtext}%")
            ->orWhere('email', 'LIKE', "%{$request->searchtext}%")
            ->orWhere('phone', 'LIKE', "%{$request->searchtext}%")
            ->withCount('students')->get();

        $category = Category::where('name', 'LIKE', "%{$request->searchtext}%")
            ->get();

        return view('search',[
            "students"  =>$students,
            "teachers"  =>$teachrs,
            "category"  =>$category,
            'req'       =>$request->searchtext
        ]);
    }

    public function report()
    {
        return view('report',[
            "users" => User::all()
        ]);
    }

    public function report_ajax(Request $request)
    {

        $request->validate([
            "object"    =>['required'],
            "status"    =>['required'],
            "user"      =>['required','integer'],
            "duration"  =>['required']
        ]);

        if(strpos($request->duration,' to ')) {

            $date = explode(' to ', $request->duration);
            $date1 = $date[0];
            $date2 = $date[1];

            $repo = Activity::with('subject','causer')->whereBetween(
                'created_at',[$date1,$date2]
            )->where([
                ['causer_id',$request->user],
                ['description',$request->status],
                ['log_name',$request->object]
                ])->get();

            $counter = 1 ;

            $de = '<div class="table-responsive">
                    <table class="table table-hover table-borderless ">
                      <thead>
                        <tr class="border-bottom">
                          <th scope="col">#</th>
                          <th scope="col">Date</th>
                          <th style="">Name of object</th>
                          
                          <th scope="col">description</th>
                          <th scope="col">Settings</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white">';

            foreach ($repo as $item) {

                    $de .= '<tr >
                          <td class="">'.$counter++.'</td>
                          <td class="">
                          '.Carbon::parse($item->created_at)->isoFormat('dddd, MMMM Do YYYY, hh:mm A').'
                          </td>
                          
                          <td style="font-size:15px">
                            <p class="badge badge-dark d-block text-left ">
                              '.
                                $item->subject->parent_name.' '.$item->subject->name
                                .'
                            </p>
                          </td>
                          
                          <td class="">
                            <p> <a href="'.url('/history?type=user&id='.$item->causer->id).'">'.$item->causer->name.'</a> '.$item->description.' => '.$item->log_name.'</p>
                          </td>
                          
                          <td class="">
                           
                        ';
                    if ($item->log_name == 'Category' and $item->description == 'created') {
                            $de.='<a  class="btn btn-primary " href="'.route('cat.show',$item->properties['attributes']['id']).'"> Show details </a>';

                        } else if ($item->log_name == 'Students' and $item->description == 'created') {
                            $de.= '<a  class="btn btn-primary " href = "'.route('students.show',$item->properties['attributes']['id']).'" > Show details </a >';

                        } else if ($item->log_name == 'Students' and $item->description == 'restored') {
                            $de.='<a  class="btn btn-primary " href = "'.route('students.show',$item->properties['attributes']['id']).'" > Show details </a >';

                        } else if ($item->log_name == 'Category' and $item->description == 'deleted') {
                            $de.='<button type = "button" class="btn btn-primary getDetaislData" data-type = "delete_category" data-id = "'.$item->id.'" data-token = "'.csrf_token().'" data-toggle = "modal" data-target = "#exampleModal" >
                                Show details
                            </button >';

                        } else if ($item->log_name == 'Students' and $item->description == 'deleted') {
                            $de.='<button type = "button" class="btn btn-primary getDetaislData" data-type = "delete_students" data-id = "'.$item->id.'" data-token = "'.csrf_token().'" data-toggle = "modal" data-target = "#exampleModal" >
                                Show details
                            </button >';

                        } else if ( $item->description == 'updated') {
                            $de.='<button type = "button" class="btn btn-primary getDetaislData" data-type = "updated" data-id = "'.$item->id.'" data-token = "'.csrf_token().'" data-toggle = "modal" data-target = "#exampleModal" >
                                Show details
                            </button >';
                        }
                            
                    $de.='</td>
                        </tr> ';
                }



            $de .= '
            </tbody>
                </table>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                  <div class="modal-dialog" style="max-width: 642px">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="backData">
                        ...
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </dsiv>';



            $de .= "
            <script>
            $('.getDetaislData').on('click',function (e) {
            
                var token = $(this).data('token');
                var id = $(this).data('id');
                var type = $(this).data('type');
                $.ajax({
                  url: link + '/history/details',
                  method: 'post',
                  data: {
                    '_token': token,
                    'id': id,
                    'type': type,
                  },
                
                  success: function (data) {
                        if (data.status == '1'){
                            console.log(data.msg);
    
                            $('#backData').html(data.msg);
                        }
                    },
            
                })
              });
            </script>
            ";




            return response()->json([
                "status"    => '1',
                "msg"       => $de,
            ]);



        } else {


        }


        return $repo;




    }

    public function popup (Request $request)
    {
        $de = '';

        $today = Carbon::now()->format('Y-m-d');

        $remember = Remember::select('id','time')->where('date',$today)->get();

        foreach ($remember as $item) {
            $startTime = Carbon::parse(now('Africa/Cairo'))->timestamp;
            $finishTime = Carbon::parse($item->time)->timestamp;

            $totalDuration = $finishTime - $startTime;
            $newTime = $totalDuration * 1000;
            if ($newTime > 1000) {
                $de .= "
            <script>
            var ss_".$item->id." =  setInterval(() => {
                 $('.popup-main-class').css(
                     'display' , 'flex'
                 );
//                console.log('ss_".$item->id."')
                                    clearInterval(ss_".$item->id.")    ;
                                    }, ".$newTime.");
            </script>
            ";
            }


        }


            return response()->json([
                "status"    => '1',
                "msg"       => $de,
            ]);
    }
}



















