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

    <form wire:submit.prevent="sendPasswordResetLink">
        <h1 class="mb-6 text-2xl font-semibold text-center text-gray-800">Forgot Password</h1>
        <p class="mb-6 text-sm text-center text-gray-600">
            Forgot your password? No problem. Just let us know your email address, and we will email you a password reset
            link that will allow you to choose a new one.
        </p>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
            <input wire:model="email" id="email" type="email"
                class="block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500
                @error('email') border-red-500 @else border-gray-300 @enderror"
                required autofocus autocomplete="username">
            @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-2 text-white transition duration-200 bg-teal-600 rounded-md hover:bg-teal-700">
            Send Password Reset Link
        </button>

        <!-- Links -->
        <div class="flex justify-between mt-6 text-sm text-gray-600">
            <a href="{{ route('login') }}" class="text-teal-600 hover:underline">Login</a>
            <a href="{{ route('register') }}" class="text-teal-600 hover:underline">Register</a>
        </div>
    </form>
</div>
