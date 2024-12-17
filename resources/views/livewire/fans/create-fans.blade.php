<div>
        <form wire:submit="registerQueue">
            <div class="row">
                {{-- <div class="input-field col s12">
                    <h5 class="ml-4">Total {{ $queue_number}} queue number</h5>
                </div> --}}
                <div class="input-field col s12">
                    <h5 class="ml-4">Please fill the form to get the {{ $cosplayerName}} queue number, Thank you</h5>
                </div>
            </div>

            <!-- Name Input -->
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="pt-2 material-icons prefix">person_outline</i>
                    <input wire:model="name" id="name" type="text" class="validate" name="name">
                    <label for="name">Name</label>
                    @error('name')
                        <span class="helper-text" data-error="{{ $message }}">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Phone Number Input -->
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="pt-2 material-icons prefix">phone</i>
                    <input wire:model="phone" id="phone" type="tel" class="validate" name="phone">
                    <label for="phone">Number Phone</label>
                    @error('phone')
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
                        Queue Now!
                    </button>
                </div>
            </div>
        </form>
</div>
