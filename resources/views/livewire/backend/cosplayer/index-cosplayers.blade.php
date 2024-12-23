<?php

use Livewire\Volt\Component;
use App\Models\Cosplayer;
use App\Models\Fan;
use App\Models\FanQueue;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $cosplayers;

    public function mount()
    {
        $this->cosplayers = Cosplayer::all();
    }

    public function clearAllRecords($cosplayerId)
    {
        try {
            // Validate the cosplayer ID
            $cosplayer = Cosplayer::findOrFail($cosplayerId);

            // Delete related records in a transaction
            \DB::transaction(function () use ($cosplayerId) {
                // Get fan IDs associated with the cosplayer from FanQueue
                $fanIds = FanQueue::where('cosplayer_id', $cosplayerId)->pluck('fan_id');

                // Delete records in FanQueue for the cosplayer
                FanQueue::where('cosplayer_id', $cosplayerId)->delete();

                // Delete records in Fans table using the collected fan IDs
                Fan::whereIn('id', $fanIds)->delete();
            });

            session()->flash('success', "All records for cosplayer '{$cosplayer->cosplayer_name}' have been cleared!");
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while clearing records: ' . $e->getMessage());
        }
    }
};
?>


<div class="card">
    <h5 class="card-header">Cosplayer Queue Records (clear by manual if needed)</h5>
    <div class="card-body">
        <!-- Success and Error Alerts -->
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

        <!-- Cosplayer Records Table -->
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cosplayer Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cosplayers as $cosplayer)
                        <tr>
                            <td>{{ $cosplayer->cosplayer_name }}</td>
                            <td>
                                @if (Auth::user()->role_id === 1)
                                    <button wire:click="clearAllRecords({{ $cosplayer->id }})" class="btn btn-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                @else
                                    <span class="text-muted">No Permission</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
