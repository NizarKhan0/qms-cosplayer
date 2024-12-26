<?php

namespace App\Http\Controllers;

use App\Models\FanQueue;
use App\Models\Cosplayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function mainCosplayers()
    {
        // Get cosplayers with role_id = 3
        //relation ni agak pening sebab dia tak amik role_id dari
        //  table user direct dia amik dari cosplayer punya table
        $cosplayers = Cosplayer::whereHas('user', function ($query) {
            $query->where('role_id', 3);
        })
            ->withCount(['fanQueues' => function ($query) {
                $query->where('status', 'Pending');
            }])
            ->get();

        // Get all session keys for fan queues
        $queueStatuses = collect($cosplayers)->mapWithKeys(function ($cosplayer) {
            $sessionKey = "fanqueue{$cosplayer->id}";
            $queueData = Session::get($sessionKey);

            if ($queueData) {
                // Check if the queue still exists in database
                $fanQueue = FanQueue::where('fan_id', $queueData['fan_id'])
                    ->where('cosplayer_id', $cosplayer->id)
                    ->whereIn('status', ['Pending', 'Queue Now'])
                    ->exists();

                return [$cosplayer->id => $fanQueue];
            }

            return [$cosplayer->id => false];
        });
        // dd($queueStatuses);

        return view('mainCosplayers', compact('cosplayers', 'queueStatuses'));
    }

    // public function index()
    // {
    //     // Get users with role_id = 3
    //     $users = User::where('role_id', 3)->get();

    //     // Get cosplayers whose user_id matches the users with role_id = 3
    //     $cosplayers = Cosplayer::whereIn('user_id', $users->pluck('id'))->get();

    //     return view('index', compact('cosplayers'));
    // }
    public function dashboard()
    {
        $cosplayers = Cosplayer::whereHas('user', function ($query) {
            $query->where('role_id', 3);
        })->get();

        return view('backend.dashboard', compact('cosplayers'));
    }
}
