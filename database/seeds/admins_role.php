<?php

use App\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class admins_role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // $developer_user = User::create([
        //     'name' => "Sayed Khaled",
        //     'email' => "sayed1@gmail.com",
        //     'password' => Hash::make("87654321"),
        // ]);
        // $developer = Role::create([
        //     'name' => 'developer',
        //     'display_name' => 'Developer role', // optional
        //     'description' => 'developer', // optional
        // ]);
        // $developer_user->attachRole('developer');
        // $user = User::where('id','5')->get()[0];
        // $role = Role::where('name','support')->get()[0];
        // $user->attachRole($role);

    }
}
