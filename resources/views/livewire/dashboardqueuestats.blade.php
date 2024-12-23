<?php

use Livewire\Volt\Component;
use App\Models\FanQueue;
use App\Models\Cosplayer;

new class extends Component {
    public $pendingQueue;
    public $callInQueue;
    public $completedQueue;
    public $cosplayerId;

    public function mount()
    {
        $this->cosplayerId = Cosplayer::where('user_id', auth()->user()->id)->first()->id;

        $this->updateQueueCounts();
    }

    public function updateQueueCounts()
    {
        $this->pendingQueue = FanQueue::join('cosplayers', 'fan_queues.cosplayer_id', '=', 'cosplayers.id')
            ->where('cosplayers.id', $this->cosplayerId)
            ->where('fan_queues.status', 'pending')
            ->count();

        $this->callInQueue = FanQueue::join('cosplayers', 'fan_queues.cosplayer_id', '=', 'cosplayers.id')
            ->where('cosplayers.id', $this->cosplayerId)
            ->where('fan_queues.status', 'queue now')
            ->count();

        $this->completedQueue = FanQueue::join('cosplayers', 'fan_queues.cosplayer_id', '=', 'cosplayers.id')
            ->where('cosplayers.id', $this->cosplayerId)
            ->where('fan_queues.status', 'complete')
            ->count();
    }

    // This method will be called by Livewire when polling occurs
    public function pollQueueStatus()
    {
        $this->updateQueueCounts();
    }
}; ?>

<div>
    <div wire:poll.1s="pollQueueStatus"> <!-- Set polling interval (e.g., 1s) -->
        <div class="text-center row">
            <div class="mb-4 col-lg-4 col-md-12 col-6">
                <div class="card border-danger">
                    <div class="card-body">
                        <span class="mb-1 fw-semibold d-block text-danger">Pending Queue</span>
                        <h3 class="mb-2 card-title text-danger">{{ $pendingQueue }}</h3>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-lg-4 col-md-12 col-6">
                <div class="card border-primary">
                    <div class="card-body">
                        <span class="mb-1 fw-semibold d-block text-primary">Queue Now</span>
                        <h3 class="mb-2 card-title text-primary">{{ $callInQueue }}</h3>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-lg-4 col-md-12 col-6">
                <div class="card border-success">
                    <div class="card-body">
                        <span class="mb-1 fw-semibold d-block text-success">Completed Queue</span>
                        <h3 class="mb-2 card-title text-success">{{ $completedQueue }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
