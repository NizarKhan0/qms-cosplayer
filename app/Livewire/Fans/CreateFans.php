<?php

namespace App\Livewire\Fans;

use App\Models\Fan;
use Livewire\Component;
use App\Models\FanQueue;
use App\Models\Cosplayer;
use Livewire\Attributes\Validate;


class CreateFans extends Component
{

    #[Validate('required|unique:fans,name|min:5')]
    public $name = '';
    #[Validate('required|unique:fans,phone|min:8')]
    public $phone = '';
    public $queue_number = null;
    public $cosplayerId = null;
    public $cosplayerName = '';
    public $pendingQueue = null;
    public $totalQueue = null;
    public $callInQueue = null;

    // Listens for the 'fanRegistered' event
    protected $listeners = ['fanRegistered' => 'reloadFans'];

    public function mount($cosplayerId)
    {
        $this->cosplayerId = $cosplayerId;

        // Get cosplayer info
        $cosplayer = Cosplayer::find($cosplayerId);
        if ($cosplayer) {
            $this->cosplayerName = $cosplayer->cosplayer_name;
        }

        // Calculate the next queue number and pending queue
        $this->updateQueueInfo();
    }


    public function updateQueueInfo()
    {
        // Get the maximum queue number for the given cosplayer and increment by 1
        $this->queue_number = FanQueue::where('cosplayer_id', $this->cosplayerId)->max('queue_number') + 1;

        // Get the count of pending queue for the given cosplayer
        $this->pendingQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->where('status', 'pending')
            ->count();

        // Get the total queue number for the given cosplayer
        // $this->totalQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)->count();

        // Get the latest queue number with the status 'queue now'
        // $this->callInQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
        //     ->where('status', 'queue now')
        //     ->max('queue_number');

        // Get the latest 5 queue numbers with the status 'queue now'
        $this->callInQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->where('status', 'queue now')
            ->orderBy('queue_number', 'asc') // Sort by queue_number in ascending order
            ->take(6) // Limit to the latest 5
            ->get();
    }

    public function reloadFans()
    {
        // This method will be called when the 'fanRegistered' event is emitted
        $this->updateQueueInfo();  // Update queue info after a fan is registered
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

        // Set the queue number to display to the user
        $this->queue_number = $queueNumber;

        // Flash success message for Livewire to pick up
        // session()->flash('success', 'You have successfully joined the queue. Your queue number is ' . $queueNumber);


        // Redirect with success message
        // return redirect('/');
        // Redirect to home page with success message using `with()`
        return redirect()->route('home')->with('success', 'You have successfully joined the queue. Your queue number is ' . $queueNumber);
    }

    public function render()
    {
        return view('livewire.fans.create-fans');
    }
}
