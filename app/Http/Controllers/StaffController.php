<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class StaffController extends Controller
{
    
    public function index()
    {
        $users = User::with('roles')->orderBy('id','DESC')->paginate(50);
        
        return view('staff.allusers',[
            'users' => $users
        ]);
        
    }

   
    public function create()
    {
        $roles = Permission::orderBy('ordernum','ASC')->get();
        // return $roles = Role::all();
        return view('staff.createuser',['roles'=>$roles]);
    }

    public function store(Request $request)
    {
//        return $request;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);



            $user = User::create([
                "name"        =>$request->name,
                "email"       =>$request->email,
                "password"     => Hash::make($request->password),
                
            ]);

            if ($user){
                if($request->has('role') && count($request->role) >= 1 ) {
                    $user->attachPermissions($request->role);
                }
                return response()->json([
                    "status"    => '1',
                    "msg"       => 'Thanks for sending us .. we will contact you',
                ]);
            } else { 

                return response()->json([
                    "status"    => '0',
                    "msg"       => 'Something is wrong please refresh page and try again'
                ]);
            }

    }

    public function show($id)
    {
        // 
    }

    public function edit($id)
    {
        $roles = Permission::orderBy('ordernum','ASC')->get();
        $user = User::where('id',$id)->with('roles')->get();
        return view('staff.edituser',[
            'user'=>$user,
            'roles'=>$roles
        ]);
    }

    public function updateUser(Request $request)
    {
        // return $request;
        $request->validate([
            'i_df' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,'.request()->segment($request->i_df).'.id'],
            // 'old_password' => ['sometimes','nullable'],
            // 'new_password' => ['required_with:old_password', 'min:8', 'confirmed'],
            'old_password' => "sometimes|nullable",
            'new_password' => "required_with:old_password|confirmed",
            
        ]);

        $newSS = User::where('id',$request->i_df)->get();

        if (!is_null($request->old_password)){ 
                $request->validate([
                'old_password' => "required",
                'new_password' => "required|confirmed|min:8",
            ]);
            if ( $newSS[0]->password != Hash::make($request->password)) {
                return response()->json([
                    "status"    => '3',
                    "msg"       => 'Password| Old password incorrect'
                ]);
            }
        }

       


            $user = User::whereId($request->i_df)->update([
                "name"        =>$request->name,
                "email"       =>$request->email,
                "password"     => Hash::make($request->password),
                
            ]);
            
            if ($user){

                $newSS[0]->syncPermissions($request->role);
                
                return response()->json([
                    "status"    => '1',
                    "msg"       => 'Edit successfully',
                ]);
            } else { 

                return response()->json([
                    "status"    => '0',
                    "msg"       => 'Something is wrong please refresh page and try again'
                ]);
            }

    }

    public function deleteuser(Request $request)
    {
        $sliderDelete = User::destroy($request->id); 

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
}
