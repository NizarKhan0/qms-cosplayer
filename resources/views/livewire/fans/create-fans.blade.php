<div>

    <div wire:poll="reloadFans">
        <div class="row">
            <div class="input-field col s12 text-center">
                <h5>Fill in the form to get into {{ $cosplayerName }}'s queue. Thank you!</h5>
            </div>
            <div class="input-field col s12">
                <h6 class="ml-4"><strong>Current Total Queue Numbers:</strong> {{ $pendingQueue }}</h6>
                <div class="mt-3">
                    <h6 class="ml-4"><strong>Fans Currently Called In:</strong></h6>
                    <ul class="collection ml-4">
                        @forelse ($callInQueue as $queue)
                            <li class="collection-item">
                                <span class="queue-number">Queue #{{ $queue->queue_number }}</span> -
                                <span class="fan-name">Name: {{ $queue->fan->name }}</span>
                            </li>
                        @empty
                            <li class="collection-item">No fans in the call-in queue yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        @if($userQueueInfo)
            <div class="card-panel teal lighten-5">
                <h6><strong>Your Queue Information (Please screenshot for your reference):</strong></h6>
                <p><strong>Name:</strong> {{ $userQueueInfo['name'] }}</p>
                <p><strong>Queue Number:</strong> #{{ $userQueueInfo['queue_number'] }}</p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge {{ strtolower($userQueueInfo['status']) === 'pending' ? 'red' : (strtolower($userQueueInfo['status']) === 'queue now' ? 'blue' : 'green') }}">
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
