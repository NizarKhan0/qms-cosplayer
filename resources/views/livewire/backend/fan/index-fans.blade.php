<?php

use Livewire\Volt\Component;
use App\Models\Fan;
use App\Models\FanQueue;
use App\Models\Cosplayer;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = ''; // Search property

    #[On('fanRegistered')]
    public function reloadFans()
    {
        return $this->getFanQueues();
    }

    public function getFanQueues()
    {
        // Base query
        $query = FanQueue::with('fan', 'cosplayer');

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->whereHas('fan', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('queue_number', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhereHas('cosplayer', function ($subQuery) {
                    $subQuery->where('cosplayer_name', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Check if the logged-in user has role_id = 1
        if (Auth::user()->role_id === 1) {
            // If role_id = 1, show all fan queues for all cosplayers
            return $query->paginate(10);
        } else {
            // If role_id is not 1, show only the fan queues for the logged-in cosplayer
            $cosplayerId = Auth::user()->id; // Get the cosplayer ID associated with the logged-in user
            return $query->where('cosplayer_id', $cosplayerId)->paginate(10);
        }
    }

    public function updateStatus($fanQueueId, $status)
    {
        $fanQueue = FanQueue::find($fanQueueId);

        if ($fanQueue) {
            $fanQueue->status = $status;
            $fanQueue->save();

            // Send success notification
            session()->flash('success', 'Status updated successfully!');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}; ?>

<div>
    <div wire:poll="reloadFans" class="row">
        <div>
            @if (session()->has('success'))
                <div class="alert alert-success">
                    <h5 class="green lighten-4">{{ session('success') }}</h5>
                </div>
            @endif
        </div>

        <div class="col s12">
            <!-- New Search Input -->
            <div class="input-field">
                <input type="text" wire:model.live="search" placeholder="Search by Name, Queue Number, or Status"
                    class="validate">
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12">
                            @php
                                $fanQueues = $this->getFanQueues();
                            @endphp
                            <table id="myTable" class="display">
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
                                    @foreach ($fanQueues as $fan)
                                        <tr>
                                            <td>{{ $fan->fan->name }}</td>
                                            <td>
                                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $fan->fan->phone) }}"
                                                    target="_blank">
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
                                                <select
                                                    wire:change="updateStatus({{ $fan->id }}, $event.target.value)"
                                                    class="browser-default">
                                                    <option value="" disabled selected>Change Status</option>
                                                    <option value="Queue Now"
                                                        {{ $fan->status === 'Queue Now' ? 'selected' : '' }}>
                                                        Queue Now
                                                    </option>
                                                    <option value="Complete"
                                                        {{ $fan->status === 'Complete' ? 'selected' : '' }}>
                                                        Complete
                                                    </option>
                                                    <option value="Pending"
                                                        {{ $fan->status === 'Pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination Links -->
                            <div class="pagination center-align">
                                @if ($fanQueues->lastPage() > 1)
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($fanQueues->onFirstPage())
                                            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                                        @else
                                            <li class="waves-effect"><a wire:click="previousPage" href="#!"><i class="material-icons">chevron_left</i></a></li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach(range(1, $fanQueues->lastPage()) as $page)
                                            @if($page == $fanQueues->currentPage())
                                                <li class="active"><a href="#!">{{ $page }}</a></li>
                                            @else
                                                <li class="waves-effect"><a wire:click="gotoPage({{ $page }})" href="#!">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($fanQueues->hasMorePages())
                                            <li class="waves-effect"><a wire:click="nextPage" href="#!"><i class="material-icons">chevron_right</i></a></li>
                                        @else
                                            <li class="disabled"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
