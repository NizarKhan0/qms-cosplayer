<?php

use Livewire\Volt\Component;
use App\Models\Fan;
use App\Models\FanQueue;
use App\Models\Cosplayer;

new class extends Component {
    public $fans;

    protected $listeners = ['fanRegistered' => 'reloadFans'];

    public function mount()
    {
        // Fetch fans when the component mounts
        $this->reloadFans();
    }

    public function reloadFans()
    {
        // Check if the logged-in user has role_id = 1
        if (Auth::user()->role_id === 1) {
            // If role_id = 1, show all fan queues for all cosplayers
            $this->fans = FanQueue::with('fan', 'cosplayer')->get();
        } else {
            // If role_id is not 1, show only the fan queues for the logged-in cosplayer
            $cosplayerId = Auth::user()->id; // Get the cosplayer ID associated with the logged-in user
            $this->fans = FanQueue::with('fan', 'cosplayer')
                ->where('cosplayer_id', $cosplayerId) // Filter by cosplayer_id
                ->get();
        }
    }

    public function updateStatus($fanQueueId, $status)
    {
        $fanQueue = FanQueue::find($fanQueueId);

        if ($fanQueue) {
            $fanQueue->status = $status;
            $fanQueue->save();
        }

        $this->reloadFans();
    }
}; ?>

<div wire:poll="reloadFans" class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        <table id="page-length-option" class="display">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Queue Number</th>
                                    <th>Status</th>
                                    <th>Cosplayer Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fans as $fan)
                                    <tr>
                                        <td>{{ $fan->fan->name }}</td>
                                        {{-- <td>{{ $fan->fan->phone }}</td> --}}
                                        <td>
                                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $fan->fan->phone) }}" target="_blank">
                                                {{ $fan->fan->phone }}
                                            </a>
                                        </td>


                                        <td>{{ $fan->queue_number }}</td>
                                        <td>
                                            @if ($fan->status === 'Queue Now')
                                                <span class="chip blue white-text">Queue Now</span>
                                            @elseif ($fan->status === 'Complete')
                                                <span class="chip green white-text">Complete</span>
                                            @else
                                                <span class="chip red white-text">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $fan->cosplayer->cosplayer_name }}</td>
                                        <td>
                                            <select wire:change="updateStatus({{ $fan->id }}, $event.target.value)"
                                                class="browser-default">
                                                <option value="" disabled selected>Change Status</option>
                                                <option value="Queue Now"
                                                    {{ $fan->status === 'Queue Now' ? 'selected' : '' }}>Queue Now
                                                </option>
                                                <option value="Complete"
                                                    {{ $fan->status === 'Complete' ? 'selected' : '' }}>Complete
                                                </option>
                                                <option value="Pending"
                                                    {{ $fan->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                            </select>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
