<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\Fan;
use App\Models\FanQueue;
use App\Models\Cosplayer;
use Illuminate\Support\Facades\Session;

new class extends Component {
    #[Validate('required|min:5')]
    public $name = '';
    public $queue_number = null;
    public $cosplayerId = null;
    public $cosplayerName = '';
    public $pendingQueue = null;
    public $totalQueue = null;
    public $callInQueue = null;
    public $userQueueInfo = null;

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
        $sessionKey = "fanqueue{$this->cosplayerId}";

        if (Session::has($sessionKey)) {
            $queueData = Session::get($sessionKey);
            $fanQueue = FanQueue::where('fan_id', $queueData['fan_id'])
                ->where('cosplayer_id', $this->cosplayerId)
                ->first();

            if ($fanQueue) {
                $this->userQueueInfo = [
                    'queue_number' => $fanQueue->queue_number,
                    'name' => $fanQueue->fan->name,
                    'status' => $fanQueue->status,
                ];
            }
        }
    }

    public function updateQueueInfo()
    {
        $this->queue_number = FanQueue::where('cosplayer_id', $this->cosplayerId)->max('queue_number') + 1;

        $this->pendingQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->where('status', 'pending')
            ->count();

        $this->callInQueue = FanQueue::where('cosplayer_id', $this->cosplayerId)
            ->where('status', 'queue now')
            ->orderBy('queue_number', 'asc')
            ->take(10)
            ->get();
    }

    #[On('fanRegistered')]
    public function reloadFans()
    {
        $this->checkExistingQueue();
        $this->updateQueueInfo();
    }

    public function registerQueue()
    {
        $this->validate();

        // Check if the name already exists for the current cosplayer
        $existingFanQueue = FanQueue::whereHas('fan', function ($query) {
            $query->where('name', $this->name);
        })
            ->where('cosplayer_id', $this->cosplayerId)
            ->exists();

        if ($existingFanQueue) {
            session()->flash('error', 'The name "' . $this->name . '" is already in the queue for this cosplayer.');
            return;
        }

        // Create the fan
        $fan = Fan::create([
            'name' => $this->name,
        ]);

        // Generate a queue number
        $queueNumber = FanQueue::where('cosplayer_id', $this->cosplayerId)->max('queue_number') + 1;

        // Create the fan queue
        $fanQueue = FanQueue::create([
            'fan_id' => $fan->id,
            'cosplayer_id' => $this->cosplayerId,
            'queue_number' => $queueNumber,
            'status' => 'Pending',
        ]);

        // Store in session (expires in 24 hours)
        $sessionKey = "fanqueue{$this->cosplayerId}";
        Session::put($sessionKey, [
            'fan_id' => $fan->id,
            'queue_number' => $queueNumber,
        ]);
        Session::save();

        $this->userQueueInfo = [
            'queue_number' => $queueNumber,
            'name' => $this->name,
            'status' => 'pending',
        ];

        session()->flash('success', 'You have successfully joined the queue. Your queue number is ' . $queueNumber);
    }
}; ?>

<div class="max-w-2xl p-4 mx-auto">
    <div wire:poll.keep-alive="reloadFans" class="space-y-6">
        {{-- <div wire:poll.1s="reloadFans" class="space-y-6"> --}}
        <!-- Title Section -->
        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow-md">
            <!-- Heading and Description -->
            <div>
                <h4 class="text-xl font-semibold text-gray-800">{{ $cosplayerName }}'s Queue</h4>
                <p class="text-sm text-gray-600">Fill out the form below to join the queue and stay updated on your
                    position.</p>
            </div>

            <!-- Back Button -->
            <a wire:navigate href="{{ route('mainCosplayers') }}"
                class="flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-700">
                Back
            </a>
        </div>

        <div class="container max-w-2xl p-4 mx-auto">
            <!-- Session Messages -->
            @if (session()->has('success'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- User Queue Information or Registration Form -->
            <div class="flex flex-col p-4 mt-2 bg-white rounded-lg shadow-md">
                @if ($userQueueInfo)
                    <div class="p-4 text-center bg-teal-100 rounded-lg">
                        <h6 class="mb-4 text-lg font-medium text-teal-800">
                            <strong>Your Queue Information (please screenshot for your reference):</strong>
                        </h6>
                        <p class="text-teal-700"><strong>Name:</strong> {{ $userQueueInfo['name'] }}</p>
                        <p class="mt-2 text-teal-700"><strong>Queue Number:</strong>
                            #{{ $userQueueInfo['queue_number'] }}</p>
                        <p class="mt-2 text-teal-700">
                            <strong>Status:</strong>
                            <span
                                class="inline-block px-4 py-2 rounded-full text-white text-sm font-semibold
                                {{ strtolower($userQueueInfo['status']) === 'pending' ? 'bg-red-500' : (strtolower($userQueueInfo['status']) === 'queue now' ? 'bg-blue-500' : 'bg-green-500') }}">
                                {{ ucfirst($userQueueInfo['status']) }}
                            </span>
                        </p>
                    </div>
                @else
                    <form wire:submit="registerQueue" class="space-y-6 bg-white rounded-lg shadow-md">
                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-center text-gray-700">Your
                                Name</label>
                            <input wire:model="name" id="name" type="text"
                                class="w-full p-3 mt-1 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="e.g. Nizar">
                            @error('name')
                                <p class="mt-1 text-sm text-center text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" name="cosplayer_id" wire:model="cosplayer_id">

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit"
                                class="w-full py-3 font-semibold text-white rounded-lg bg-gradient-to-r from-teal-400 to-teal-600 hover:bg-gradient-to-l from-teal-500 to-teal-700">
                                Join Queue
                            </button>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Queue Information Section -->
            <div class="flex flex-col p-4 mt-6 bg-white rounded-lg shadow-md">
                <h5 class="text-lg font-medium text-center text-gray-700">Current Queue Status</h5>
                <div class="mt-4">
                    <p class="text-gray-600">
                        <strong>Total Queue Numbers:</strong>
                        <span class="px-3 py-1 text-gray-800 bg-gray-200 rounded-full">{{ $pendingQueue }}</span>
                    </p>
                    <p class="mt-3 text-gray-600"><strong>Fans Currently Called In:</strong></p>

                    <!-- Fans Called In Grid -->
                    <div class="grid grid-cols-2 gap-4 mt-4 place-items-center sm:grid-cols-2 lg:grid-cols-3">
                        @forelse ($callInQueue as $queue)
                            <div
                                class="flex flex-col items-center p-4 text-center rounded-lg shadow-sm bg-gradient-to-r from-blue-50 to-blue-100">
                                <span class="text-lg font-semibold text-gray-700">Queue
                                    #{{ $queue->queue_number }}</span>
                                <span class="text-gray-600">Name: {{ $queue->fan->name }}</span>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-600 rounded-lg bg-gray-50 col-span-full">
                                No fans in the call-in queue yet.
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

