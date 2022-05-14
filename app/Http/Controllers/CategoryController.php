<?php

namespace App\Http\Controllers;

use App\Models\Category;
// use function Ramsey\Uuid\v1;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class CategoryController extends Controller
{
    public function index ()
    {
        $cat = Category::with('newparent')->orderBy('id','DESC')->paginate(50);
        return view('categories.shawall',[
            'cat' => $cat
        ]);
    }
    public function show ($id)
    {
        // $data = Category::with('person')->where('id',$id)->orderBy('id','DESC')->paginate(50);
        $data = Category::with('newparent')->find($id);


        return view('categories.showOneCat',[
            'data' => $data,
            'status_id' =>'all'
        ]);
    }
    public function categoryAdd ()
    {
        return view('categories.addcategory');
    }
    public function categoryEdit ($id)
    {
        $catOne = Category::whereId($id)->get();
        return view('categories.editcategory',[
            'catOne' => $catOne
        ]);
    }
    public function saveCat (Request $request)
    {
        $request->validate([
             'name' => 'required|unique:categories'
         ]);
        $slider = Category::create([
            "name"     =>$request->name,

        ]);


        if ($slider)
            return response()->json([
                "status"    => '1',
                "msg"       => 'Added successfully'
            ]);
        else
            return response()->json([
                "status"    => '0',
                "msg"       => 'Sorry, please try again'
            ]);
    }
    public function editCat (Request $request)
    {

        $request->validate([
             'name' => 'required'
         ]);
        $slider = Category::find($request->i_d_Fname)->update([
            "name"     =>$request->name,
        ]);

        if ($slider) {

            // activity()->performedOn($slider)->withProperties(['url' => 'testurl', 'user' => 'testUser']);
            return response()->json([
                "status"    => '1',
                "msg"       => 'Edit Successfuly'
            ]);
        } else {
            return response()->json([
                "status"    => '0',
                "msg"       => 'Sorry, please try again'
            ]);
        }
    }
    public function categoryDelete (Request $request)
    {

        $cc =  Category::whereId($request->id)->with('person')->get();
        $cci =  Category::whereId($request->id)->with('newparent')->get();
        if (count($cc[0]->person) >= 1 or count($cci[0]->newparent) >= 1) {
            return response()->json([
                "status"    => '2',
                "msg"       => 'This category has users, please delete users first'
            ]);
        } else {
            $sliderDelete = Category::destroy($request->id);

            if ($sliderDelete)
            return response()->json([
                "status"    => '1',
                "msg"       => 'Delete successfully'
            ]);
            else
            return response()->json([
                "status"    => '0',
                "msg"       => 'Sorry, please try again'
            ]);
        }
    }
}
