<?php

use Livewire\Volt\Component;
use App\Models\FanQueue;
use App\Models\Cosplayer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

new class extends Component {

    public $cosplayerId;
    public $cosplayerFans = [];
    public $allFans = [];
    public $searchName = '';
    public $searchQueueNumber = '';
    public $searchStatus = '';

    public function mount()
    {
        //All fan if admin role_id = 1
        if (Auth::user()->role_id == 1) {
            $this->allFans = FanQueue::with('fan')->get();
        };
        // Get cosplayer ID through authenticated user
        $this->cosplayerId = Cosplayer::where('user_id', Auth::user()->id)->first()->id;

        // Load fans related to the cosplayer
        $this->loadCosplayerFans();
    }

    public function loadCosplayerFans()
    {
        // Load fans related to the cosplayer
        $query = FanQueue::with('fan')->where('cosplayer_id', $this->cosplayerId);

        // Apply search filters
        if (!empty($this->searchName)) {
            $query->whereHas('fan', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%');
            });
        }

        if (!empty($this->searchQueueNumber)) {
            $query->where('queue_number', $this->searchQueueNumber);
        }

        if (!empty($this->searchStatus)) {
            $query->where('status', $this->searchStatus);
        }

        $this->cosplayerFans = $query->get();

    }

    public function updateStatus($fanQueueId, $status)
    {
        $fanQueue = FanQueue::find($fanQueueId);

        if ($fanQueue) {
            $fanQueue->status = $status;
            $fanQueue->save();
            session()->flash('success', 'Status updated successfully!');
            $this->loadCosplayerFans(); // Refresh data after update
        }
    }

    public function updated($propertyName)
    {
        // Reload fans when a search filter changes
        if (in_array($propertyName, ['searchName', 'searchQueueNumber', 'searchStatus'])) {
            $this->loadCosplayerFans();
        }
    }
};
?>

<div>
    <div wire:poll="loadCosplayerFans">
        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Filters -->
        <div class="mb-4 card">
            <h5 class="card-header">Search Fans</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" wire:model.live.debounce.250ms="searchName" class="form-control"
                            placeholder="Search by Fan Name">
                    </div>
                    <div class="col-md-4">
                        <input type="text" wire:model.live.debounce.250ms="searchQueueNumber" class="form-control"
                            placeholder="Search by Queue Number">
                    </div>
                    <div class="col-md-4">
                        <select wire:model.live.debounce.250ms="searchStatus" class="form-control">
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Queue Now">Queue Now</option>
                            <option value="Complete">Complete</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">List Fans</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Fan Name</th>
                                <th>Queue Number</th>
                                <th>Status</th>
                                <th>Cosplayer Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cosplayerFans as $fans)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $fans->fan->name }}</td>
                                    <td>{{ $fans->queue_number }}</td>
                                    @if ($fans->status === 'Pending')
                                        <td><span class="badge bg-label-danger me-1">Pending</span></td>
                                    @elseif ($fans->status === 'Queue Now')
                                        <td><span class="badge bg-label-info me-1">Queue Now</span></td>
                                    @else
                                        <td><span class="badge bg-label-success me-1">Complete</span></td>
                                    @endif
                                    <td>{{ $fans->cosplayer->cosplayer_name }}</td>
                                    <td>
                                        <select wire:change="updateStatus({{ $fans->id }}, $event.target.value)"
                                            class="browser-default">
                                            <option value="" disabled selected>Change Status</option>
                                            <option value="Queue Now" {{ $fans->status === 'Queue Now' ? 'selected' : '' }}>
                                                Queue Now
                                            </option>
                                            <option value="Complete" {{ $fans->status === 'Complete' ? 'selected' : '' }}>
                                                Complete
                                            </option>
                                            <option value="Pending" {{ $fans->status === 'Pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
</div>

