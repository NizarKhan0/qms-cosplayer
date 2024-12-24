<?php

use Livewire\Volt\Component;
use App\Models\FanQueue;
use App\Models\Cosplayer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $cosplayerId;
    public $cosplayerFans = [];
    public $allFans = [];
    public $searchName = '';
    public $searchQueueNumber = '';
    public $searchStatus = '';
    public $perPage = 5; // Number of items per page

    public function mount()
    {
        $this->cosplayerId = Cosplayer::where('user_id', Auth::user()->id)->first()->id;
    }

    public function loadCosplayerFans()
    {
        if (Auth::user()->role_id === 1) {
            $query = FanQueue::with(['fan', 'cosplayer']);
        } else {
            $query = FanQueue::with('fan')->where('cosplayer_id', $this->cosplayerId);
        }

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

        return $query->orderBy('created_at', 'desc')->paginate($this->perPage);
    }

    public function updateStatus($fanQueueId, $status)
    {
        $fanQueue = FanQueue::find($fanQueueId);

        if ($fanQueue) {
            $fanQueue->status = $status;
            $fanQueue->save();
            session()->flash('success', 'Status updated successfully!');
        }
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['searchName', 'searchQueueNumber', 'searchStatus'])) {
            $this->resetPage(); // Reset to first page when search filters change
        }
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap'; // Use Bootstrap pagination view
    }
};
?>

<div>
    <div wire:poll="$refresh">
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
                    <div class="mb-3 col-12 col-md-4">
                        <input type="text" wire:model.live.debounce.250ms="searchName" class="form-control"
                            placeholder="Search by Fan Name">
                    </div>
                    <div class="mb-3 col-12 col-md-4">
                        <input type="text" wire:model.live.debounce.250ms="searchQueueNumber" class="form-control"
                            placeholder="Search by Queue Number">
                    </div>
                    <div class="mb-3 col-12 col-md-4">
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
                            @foreach ($this->loadCosplayerFans() as $fans)
                                <tr>
                                    <td>{{ ($this->loadCosplayerFans()->currentPage() - 1) * $this->perPage + $loop->iteration }}
                                    </td>
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
                                            <option value="Queue Now"
                                                {{ $fans->status === 'Queue Now' ? 'selected' : '' }}>Queue Now</option>
                                            <option value="Complete"
                                                {{ $fans->status === 'Complete' ? 'selected' : '' }}>Complete</option>
                                            <option value="Pending" {{ $fans->status === 'Pending' ? 'selected' : '' }}>
                                                Pending</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $this->loadCosplayerFans()->links() }}
                    </div>

                </div>
            </div>
        </div>
        <!--/ Bordered Table -->

    </div>
</div>
