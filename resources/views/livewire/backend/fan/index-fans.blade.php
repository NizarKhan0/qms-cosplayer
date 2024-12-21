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

    public $search = '';

    #[On('fanRegistered')]
    public function reloadFans()
    {
        return $this->getFanQueues();
    }

    public function getFanQueues()
    {
        $query = FanQueue::with('fan', 'cosplayer');

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

        if (Auth::user()->role_id === 1) {
            return $query->paginate(8);
        } else {
            $cosplayerId = Auth::user()->id;
            return $query->where('cosplayer_id', $cosplayerId)->paginate(8);
        }
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
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    <h5 class="red lighten-4">{{ session('error') }}</h5>
                </div>
            @endif
        </div>

        <div class="col s12">
            <!-- Search and Reset Button Row -->
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                        <input type="text" wire:model.live="search"
                            placeholder="Search by Name, Queue Number, or Status" class="validate">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12">
                            @php
                                $fanQueues = $this->getFanQueues();
                            @endphp
                            <div class="responsive-table-wrapper">
                                <table id="myTable" class="display responsive-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Queue Number</th>
                                            <th>Status</th>
                                            <th class="cosplayer-name">Cosplayer Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fanQueues as $fan)
                                            <tr>
                                                <td>{{ $fan->fan->name }}</td>
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
                                                <td class="cosplayer-name">{{ $fan->cosplayer->cosplayer_name }}</td>
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
                            </div>

                            <!-- Pagination Links -->
                            <div class="pagination center-align">
                                @if ($fanQueues->lastPage() > 1)
                                    <ul class="pagination">
                                        @if ($fanQueues->onFirstPage())
                                            <li class="disabled"><a href="#!"><i
                                                        class="material-icons">chevron_left</i></a></li>
                                        @else
                                            <li class="waves-effect"><a wire:click="previousPage" href="#!"><i
                                                        class="material-icons">chevron_left</i></a></li>
                                        @endif

                                        @foreach (range(1, $fanQueues->lastPage()) as $page)
                                            @if ($page == $fanQueues->currentPage())
                                                <li class="active"><a href="#!">{{ $page }}</a></li>
                                            @else
                                                <li class="waves-effect"><a wire:click="gotoPage({{ $page }})"
                                                        href="#!">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        @if ($fanQueues->hasMorePages())
                                            <li class="waves-effect"><a wire:click="nextPage" href="#!"><i
                                                        class="material-icons">chevron_right</i></a></li>
                                        @else
                                            <li class="disabled"><a href="#!"><i
                                                        class="material-icons">chevron_right</i></a></li>
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
