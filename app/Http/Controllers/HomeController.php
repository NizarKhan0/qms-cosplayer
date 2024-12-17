<?php

namespace App\Http\Controllers;

use App\Models\Cosplayer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get cosplayers with role_id = 3
        //relation ni agak pening sebab dia tak amik role_id dari
        //  table user direct dia amik dari cosplayer punya table
        $cosplayers = Cosplayer::whereHas('user', function ($query) {
            $query->where('role_id', 3);
        })->get();

        return view('index', compact('cosplayers'));
    }

    // public function index()
    // {
    //     // Get users with role_id = 3
    //     $users = User::where('role_id', 3)->get();

    //     // Get cosplayers whose user_id matches the users with role_id = 3
    //     $cosplayers = Cosplayer::whereIn('user_id', $users->pluck('id'))->get();

    //     return view('index', compact('cosplayers'));
    // }


}
