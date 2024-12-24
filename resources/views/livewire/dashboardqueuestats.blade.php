<?php

use Livewire\Volt\Component;
use App\Models\FanQueue;
use App\Models\Cosplayer;
use App\Models\User;

new class extends Component {
    public $pendingQueue;
    public $callInQueue;
    public $completedQueue;
    public $cosplayerId;
    public $totalFans;
    public $totalCosplayers;
    public $totalUsers;

    public function mount()
    {
        $this->cosplayerId = Cosplayer::where('user_id', auth()->user()->id)->first()->id;

        $this->updateQueueCounts();

        // Check if the user has a role that grants access to the totals
        if (auth()->user()->role_id == 1) {
            // Assuming role_id 1 is for super admin
            $this->updateTotalCounts();
        }
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

    public function updateTotalCounts()
    {
        // Get the total number of fans
        $this->totalFans = FanQueue::count();

        // Get the total number of cosplayers
        $this->totalCosplayers = Cosplayer::count();

        // Get the total number of users
        $this->totalUsers = User::count();
    }

    // This method will be called by Livewire when polling occurs
    public function pollQueueStatus()
    {
        $this->updateQueueCounts();

        // Update totals if the user is super admin
        if (auth()->user()->role_id == 1) {
            $this->updateTotalCounts();
        }
    }
};
?>

<div>
    <!-- Display Error Message kalau dia nak access route yg hanya super admin je boleh access-->
    @if (session('error'))
        <div class="m-3 alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Show Total Stats if User is Super Admin (role_id == 1) -->
    @if (auth()->user()->role_id == 1)
        <div class="mt-5 text-center row">
            <div class="mb-4 col-lg-4 col-md-6 col-12">
                <div class="card border-secondary">
                    <div class="card-body">
                        <span class="mb-1 fw-semibold d-block text-secondary">Total Fans</span>
                        <h3 class="mb-2 card-title text-secondary">{{ $totalFans }}</h3>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-lg-4 col-md-6 col-12">
                <div class="card border-secondary">
                    <div class="card-body">
                        <span class="mb-1 fw-semibold d-block text-secondary">Total Cosplayers</span>
                        <h3 class="mb-2 card-title text-secondary">{{ $totalCosplayers }}</h3>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-lg-4 col-md-6 col-12">
                <div class="card border-secondary">
                    <div class="card-body">
                        <span class="mb-1 fw-semibold d-block text-secondary">Total Users</span>
                        <h3 class="mb-2 card-title text-secondary">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div wire:poll.15s="pollQueueStatus"> <!-- Set polling interval (e.g., 1s) -->
        <div class="text-center row">
            <div class="mb-4 col-lg-4 col-md-6 col-12">
                <div class="card border-danger">
                    <div class="card-body">
                        <span class="mb-1 fw-semibold d-block text-danger">Pending Queue</span>
                        <h3 class="mb-2 card-title text-danger">{{ $pendingQueue }}</h3>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-lg-4 col-md-6 col-12">
                <div class="card border-primary">
                    <div class="card-body">
                        <span class="mb-1 fw-semibold d-block text-primary">Queue Now</span>
                        <h3 class="mb-2 card-title text-primary">{{ $callInQueue }}</h3>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-lg-4 col-md-6 col-12">
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
