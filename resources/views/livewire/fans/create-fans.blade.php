<div>
    <div wire:poll="reloadFans">
        <div class="row">
            <div class="input-field col s12">
                <h5 class="ml-4">{{ $cosplayerName }} Queue System</h5>
            </div>
            <div class="input-field col s12">
                <h6 class="ml-4">Total Queue Number Now: {{ $pendingQueue }}</h6>
                <div>
                    <h6 class="ml-4">Number Call In:</h6>
                    @forelse ($callInQueue as $queue)
                        <li>
                            Queue #{{ $queue->queue_number }} - Name: {{ $queue->fan->name }}
                        </li>
                    @empty
                        <li>No fans in the call-in queue yet.</li>
                    @endforelse
                </div>
            </div>
        </div>

        @if($userQueueInfo)
            <div class="card-panel">
                <h6>Your Queue Information</h6>
                <p>Name: {{ $userQueueInfo['name'] }}</p>
                <p>Queue Number: #{{ $userQueueInfo['queue_number'] }}</p>
                <p>Status:
                    <span class="badge {{ $userQueueInfo['status'] === 'pending' ? 'orange' : ($userQueueInfo['status'] === 'queue now' ? 'green' : 'blue') }}">
                        {{ ucfirst($userQueueInfo['status']) }}
                    </span>
                </p>
            </div>
        @else
            <form wire:submit="registerQueue">
                @csrf
                <!-- Name Input -->
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="pt-2 material-icons prefix">person_outline</i>
                        <input wire:model="name" id="name" type="text" class="validate" name="name"
                            placeholder="e.g. Nizar">
                        @error('name')
                            <span class="helper-text" data-error="{{ $message }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <input type="hidden" name="cosplayer_id" wire:model="cosplayer_id">

                <!-- Submit Button -->
                <div class="pt-4 row">
                    <div class="input-field col s12">
                        <button type="submit"
                            class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">
                            Join Queue!
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
