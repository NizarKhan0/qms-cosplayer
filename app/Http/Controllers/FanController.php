<?php

namespace App\Http\Controllers;

use App\Models\Cosplayer;
use Illuminate\Http\Request;

class FanController extends Controller
{
    public function displayFans($cosplayerSlug)
    {
        $cosplayer = Cosplayer::where('slug', $cosplayerSlug)->firstOrFail();

        return view('livewire.frontend.index-fans', [
            'cosplayerId' => $cosplayer->id,
            'cosplayerName' => $cosplayer->cosplayer_name,
        ]);
    }

}
