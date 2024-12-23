<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'), function ($user) {
            $user
                ->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])
                ->save();

            event(new PasswordReset($user));
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    @section('title', 'Reset Password')

    <form wire:submit.prevent="resetPassword">
        <h1 class="mb-6 text-2xl font-semibold text-center text-gray-800">Reset Password</h1>

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

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
            <input wire:model="password" id="password" type="password"
                class="block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500
                @error('password') border-red-500 @else border-gray-300 @enderror"
                required autocomplete="new-password">
            @error('password')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Confirm
                Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password"
                class="block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500
                @error('password_confirmation') border-red-500 @else border-gray-300 @enderror"
                required autocomplete="new-password">
            @error('password_confirmation')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-2 text-white transition duration-200 bg-teal-600 rounded-md hover:bg-teal-700">
            Reset Password
        </button>

        <!-- Links -->
        <div class="flex justify-between mt-6 text-sm text-gray-600">
            <a href="{{ route('login') }}" class="text-teal-600 hover:underline">Login</a>
            <a href="{{ route('register') }}" class="text-teal-600 hover:underline">Register</a>
        </div>
    </form>
</div>
