<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    @section('title', 'Forgot Password')

    <form wire:submit="sendPasswordResetLink">
        <div class="row">
            <div class="input-field col s12">
                <h5 class="ml-4">Forgot Password</h5>
                {{-- <p class="ml-4">You can reset your password</p> --}}
                <p class="ml-4"> Forgot your password? No problem. Just let us know your email address and we will email
                    you a password reset link that will allow you to choose a new one.</p>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="pt-2 material-icons prefix">mail_outline</i>
                {{-- <input id="email" type="email">
            <label for="email" class="center-align">Email</label> --}}
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email"
                    required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button type="submit"
                    class="mb-1 btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Reset
                    Password</button>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6 m6 l6">
                <p class="margin medium-small"><a href="{{ route('login') }}">Login</a></p>
            </div>
            <div class="input-field col s6 m6 l6">
                <p class="margin right-align medium-small"><a href="{{ route('register') }}">Register</a></p>
            </div>
        </div>
    </form>
    </div>

</div>
