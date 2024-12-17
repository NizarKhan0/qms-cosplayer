<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FanController extends Controller
{
    public function displayFans($cosplayerId)
    {
        return view('livewire.fans.index-fans', [
            'cosplayerId' => $cosplayerId
        ]);
    }
}
