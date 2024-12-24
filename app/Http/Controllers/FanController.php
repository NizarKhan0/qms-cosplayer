<?php

namespace App\Http\Controllers;

use App\Models\FanQueue;
use App\Models\Cosplayer;
use Illuminate\Http\Request;

class FanController extends Controller
{
    public function displayFans($cosplayerSlug)
    {
        $cosplayer = Cosplayer::where('slug', $cosplayerSlug)->firstOrFail();

        // Check if the current fan is in the queue for this cosplayer
        $fanQueues = FanQueue::whereHas('fan', function ($query) use ($cosplayer) {
            $query->whereIn('fan_queues.status', ['Pending', 'Queue Now']);
            $query->where('fan_queues.cosplayer_id', $cosplayer->id);
        })->exists();

        return view('livewire.frontend.index-fans', [
            'cosplayerId' => $cosplayer->id,
            'cosplayerName' => $cosplayer->cosplayer_name,
        ]);
    }
}
