<?php

namespace App\Livewire\Fans;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Fan;
use App\Models\FanQueue;
use App\Models\Cosplayer;

class CreateFans extends Component
{
    #[Validate('required|unique:fans,name|min:5')]
    public $name = '';
    #[Validate('required|unique:fans,phone|min:8')]
    public $phone = '';
    public $queue_number = null;
    public $cosplayerId = null;
    public $cosplayerName = '';

    //takyah guna mount kalau dah ada pass kat redner dan dalam controller
    public function mount($cosplayerId)
    {
        //ini dari route dan controller
        // $this->cosplayerId = $cosplayerId;
        // dd($this->cosplayerId);

        $cosplayer = Cosplayer::find($cosplayerId); // Adjust this based on how you get the cosplayer data
        $this->cosplayerName = $cosplayer->cosplayer_name; // Set the name property
        $this->queue_number = FanQueue::where('cosplayer_id', $this->cosplayerId)->max('queue_number') + 1;
    }
    public function registerQueue()
    {
        $this->validate();

        // Create the fan
        $fans = Fan::create([
            'name' => $this->name,
            'phone' => $this->phone,
        ]);

        // Generate a queue number
        $queueNumber = FanQueue::where('cosplayer_id', $this->cosplayerId)->max('queue_number') + 1;

        // Create the fan queue
        $fansQueue = FanQueue::create([
            'fan_id' => $fans->id,
            'cosplayer_id' => $this->cosplayerId,
            'queue_number' => $queueNumber,
            'status' => 'pending',
        ]);

        // dd($fansQueue);

        // Set the queue number to display to the user
        $this->queue_number = $queueNumber;

        // session()->flash('status', 'Queue success for Cosplayer');
        return redirect('/');
    }
    public function render()
    {
        return view('livewire.fans.create-fans');
    }
}
