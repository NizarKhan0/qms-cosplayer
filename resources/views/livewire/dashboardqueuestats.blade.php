<?php

use Livewire\Volt\Component;
use App\Models\FanQueue;

new class extends Component {
    public $cosplayerId;
    public $pendingQueue;
    public $callInQueue;
    public $completedQueue;

    // Initialize the data when the component is mounted
    public function mount()
    {
        $this->cosplayerId = auth()->user()->id;
        $this->updateQueueInfo();
    }

    // Polling method to reload the queue data
    public function reloadQueueInfo()
    {
        $this->updateQueueInfo();
    }

    // Method to fetch and update the queue information based on cosplayer_id
    public function updateQueueInfo()
    {
        // Fetch queue counts based on cosplayer_id
        $this->pendingQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->where('status', 'pending')
            ->count();

        $this->callInQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->where('status', 'queue now')
            ->count();

        $this->completedQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->where('status', 'complete')
            ->count();
    }
};?>

<div>
    <!-- Real-time polling to reload queue info -->
    <div wire:poll="reloadQueueInfo" class="row">
        <!-- Pending Queue Card (Red) -->
        <div class="col s12 m6 l6 xl3">
            <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
                <div class="padding-4">
                    <div class="row">
                        <div class="col s7 m7">
                            <i class="mt-5 material-icons background-round">perm_identity</i>
                            <p>Pending Queue</p>
                        </div>
                        <div class="col s5 m5 right-align">
                            <h5 class="mb-0 white-text">{{ $pendingQueue }}</h5>
                            <p class="no-margin">Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Queue Now Card (Blue) -->
        <div class="col s12 m6 l6 xl3">
            <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                <div class="padding-4">
                    <div class="row">
                        <div class="col s7 m7">
                            <i class="mt-5 material-icons background-round">perm_identity</i>
                            <p>Queue Now</p>
                        </div>
                        <div class="col s5 m5 right-align">
                            <h5 class="mb-0 white-text">{{ $callInQueue }}</h5>
                            <p class="no-margin">Queue Now</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Queue Card (Green) -->
        <div class="col s12 m6 l6 xl3">
            <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                <div class="padding-4">
                    <div class="row">
                        <div class="col s7 m7">
                            <i class="mt-5 material-icons background-round">perm_identity</i>
                            <p>Completed Queue</p>
                        </div>
                        <div class="col s5 m5 right-align">
                            <h5 class="mb-0 white-text">{{ $completedQueue }}</h5>
                            <p class="no-margin">Completed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
