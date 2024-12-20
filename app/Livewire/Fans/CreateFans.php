<?php

namespace App\Livewire\Fans;

use App\Models\Fan;
use Livewire\Component;
use App\Models\FanQueue;
use App\Models\Cosplayer;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Session;

class CreateFans extends Component
{
    #[Validate('required|unique:fans,name|min:5')]
    public $name = '';
    public $queue_number = null;
    public $cosplayerId = null;
    public $cosplayerName = '';
    public $pendingQueue = null;
    public $totalQueue = null;
    public $callInQueue = null;
    public $userQueueInfo = null;

    protected $listeners = ['fanRegistered' => 'reloadFans'];

    public function mount($cosplayerId)
    {
        $this->cosplayerId = $cosplayerId;

        // Get cosplayer info
        $cosplayer = Cosplayer::find($cosplayerId);
        if ($cosplayer) {
            $this->cosplayerName = $cosplayer->cosplayer_name;
        }

        // Check if user has an existing queue
        $this->checkExistingQueue();

        // Calculate the next queue number and pending queue
        $this->updateQueueInfo();
    }

    public function checkExistingQueue()
    {
        $sessionKey = "fan_queue_{$this->cosplayerId}";
        $queueData = Session::get($sessionKey);

        // First try to get queue info from session
        if ($queueData) {
            $fanQueue = FanQueue::where('fan_id', $queueData['fan_id'])
                ->where('cosplayer_id', $this->cosplayerId)
                ->whereNotIn('status', ['complete']) // Don't show completed queues
                ->first();

            if ($fanQueue) {
                $this->setUserQueueInfo($fanQueue);
                return;
            }
        }

        // If session doesn't exist or queue not found, try to find by name if provided
        if (!empty($this->name)) {
            $fan = Fan::where('name', $this->name)->first();
            if ($fan) {
                $fanQueue = FanQueue::where('fan_id', $fan->id)
                    ->where('cosplayer_id', $this->cosplayerId)
                    ->whereNotIn('status', ['complete'])
                    ->first();

                if ($fanQueue) {
                    // Update session with found queue
                    Session::put($sessionKey, [
                        'fan_id' => $fan->id,
                        'queue_number' => $fanQueue->queue_number
                    ]);
                    Session::save();

                    $this->setUserQueueInfo($fanQueue);
                }
            }
        }
    }

    private function setUserQueueInfo($fanQueue)
    {
        $this->userQueueInfo = [
            'queue_number' => $fanQueue->queue_number,
            'name' => $fanQueue->fan->name,
            'status' => $fanQueue->status
        ];
    }

    public function updateQueueInfo()
    {
        $this->queue_number = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->max('queue_number') + 1;

        $this->pendingQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->where('status', 'pending')
            ->count();

        $this->callInQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->where('status', 'queue now')
            ->orderBy('queue_number', 'asc')
            ->take(6)
            ->get();
    }

    public function reloadFans()
    {
        $this->checkExistingQueue();
        $this->updateQueueInfo();
    }

    public function registerQueue()
    {
        $this->validate();

        // Create the fan
        $fan = Fan::create([
            'name' => $this->name,
        ]);

        // Generate a queue number
        $queueNumber = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->max('queue_number') + 1;

        // Create the fan queue
        $fanQueue = FanQueue::create([
            'fan_id' => $fan->id,
            'cosplayer_id' => $this->cosplayerId,
            'queue_number' => $queueNumber,
            'status' => 'pending',
        ]);

        // Store in session as a convenience
        $sessionKey = "fan_queue_{$this->cosplayerId}";
        Session::put($sessionKey, [
            'fan_id' => $fan->id,
            'queue_number' => $queueNumber
        ]);
        Session::save();

        $this->userQueueInfo = [
            'queue_number' => $queueNumber,
            'name' => $this->name,
            'status' => 'pending'
        ];

        session()->flash('success', 'You have successfully joined the queue. Your queue number is ' . $queueNumber);
    }

    public function render()
    {
        return view('livewire.fans.create-fans');
    }
}
