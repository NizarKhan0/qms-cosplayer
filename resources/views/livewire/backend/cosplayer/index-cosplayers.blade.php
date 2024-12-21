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

    public function clearAllRecords()
    {
        try {
            // Disable foreign key checks temporarily
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Truncate tables to clear records and reset auto-increment
            \DB::table('fan_queues')->truncate();
            \DB::table('fans')->truncate();

            // Re-enable foreign key checks
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            session()->flash('success', 'All records have been cleared, and auto-increment values have been reset!');
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while clearing records: ' . $e->getMessage());
        }
    }
}; ?>

<div>
    <div class="row">
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
            <div class="card">
                <div class="card-content">
                    <h5 class="card-title">Cosplayer Records</h5>
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th>Cosplayer Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cosplayers as $cosplayer)
                                <tr>
                                    <td>{{ $cosplayer->cosplayer_name }}</td>
                                    <td>
                                        @if (Auth::user()->role_id === 1)
                                            <button wire:click="clearAllRecords"
                                                class="btn red waves-effect waves-light">
                                                Clear All Records
                                                <i class="material-icons right">delete_forever</i>
                                            </button>
                                        @else
                                            <span class="grey-text">No Permission</span>
                                        @endif
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
