<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate(
            [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => [
                    'required',
                    'string',
                    'confirmed',
                    'min:8', // Minimum length (optional, adjust as needed)
                    'regex:/[0-9]/', // At least one number
                    'regex:/[@$!%*?&]/', // At least one special character
                ],
                'password_confirmation' => ['required', 'string', 'same:password'],
            ],
            [
                // Custom error messages
                'password.regex' => 'The password must contain at least one number, and one special character (@, $, !, %, *, ?, &).',
                'password.min' => 'The password must be at least 8 characters long.',
                'password_confirmation.same' => 'The confirmation password must match the password.',
                'email.unique' => 'The email address is already taken. Please choose a different one.',
                'name.min' => 'The cosplayer name must be at least 5 characters long.',
            ],
        );

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Create the user
        event(new Registered(($user = User::create($validated))));

        // Log the user in
        Auth::login($user);

        // Redirect the user
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    @section('title', 'Register')

    <form wire:submit.prevent="register">
        <h1 class="mb-6 text-2xl font-semibold text-center text-gray-800">Register</h1>

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Cosplayer Name</label>
            <input wire:model.defer="name" id="name" type="text"
                class="block w-full px-4 py-2 border
                @if ($errors->has('name')) border-red-500 @else border-gray-300 @endif
                rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                required autofocus>
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
            <input wire:model.defer="email" id="email" type="email"
                class="block w-full px-4 py-2 border
                @if ($errors->has('email')) border-red-500 @else border-gray-300 @endif
                rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                required>
            @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
            <input wire:model.defer="password" id="password" type="password"
                class="block w-full px-4 py-2 border
                @if ($errors->has('password')) border-red-500 @else border-gray-300 @endif
                rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                required>
            @error('password')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Confirm
                Password</label>
            <input wire:model.defer="password_confirmation" id="password_confirmation" type="password"
                class="block w-full px-4 py-2 border
                @if ($errors->has('password_confirmation')) border-red-500 @else border-gray-300 @endif
                rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                required>
            @error('password_confirmation')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
            class="w-full py-2 text-white transition duration-200 bg-teal-600 rounded-md hover:bg-teal-700">
            Register
        </button>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Already have an account?
                <a href="{{ route('login') }}" class="text-teal-600 hover:underline">Login</a>
            </p>
        </div>
    </form>
</div>
