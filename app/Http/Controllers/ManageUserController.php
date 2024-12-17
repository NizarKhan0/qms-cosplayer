<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    //List all users
    public function allUsers()
    {
        // $users = User::all();
        return view('backend.list-users',[
            // 'users' => $users,
        ]);
    }

    //List all cosplayers
    public function allCosplayers()
    {
        return view('backend.list-cosplayers');
    }

    //List all fans
    public function allFans()
    {
        return view('backend.list-fans');
    }
}
