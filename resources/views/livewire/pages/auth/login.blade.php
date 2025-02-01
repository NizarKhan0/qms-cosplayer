<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */

     public function mount()
     {
         // Auto-fill credentials in local environment
         if(app()->environment('local')){
            $this->form->fill([
                'email' => 'admin@demo.com',
                'password' => 'password',
            ]);
        }
     }
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    @section('title', 'Login')

    <form wire:submit.prevent="login">
        <h1 class="mb-6 text-2xl font-semibold text-center text-gray-800">Sign in</h1>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
            <input wire:model="form.email" id="email" type="email"
                class="block w-full px-4 py-2 border
                @if ($errors->has('form.email')) border-red-500 @else border-gray-300 @endif
                rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                required autofocus autocomplete="username">
            @error('form.email')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
            <input wire:model="form.password" id="password" type="password"
                class="block w-full px-4 py-2 border
                @if ($errors->has('form.password')) border-red-500 @else border-gray-300 @endif
                rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                required autocomplete="current-password">
            @error('form.password')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me and Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center text-sm text-gray-600">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="text-teal-600 border-gray-300 rounded shadow-sm focus:ring-teal-500">
                <span class="ml-2">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-teal-600 hover:underline">Forgot
                    password?</a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-2 text-white transition duration-200 bg-teal-600 rounded-md hover:bg-teal-700">
            Login
        </button>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Don't have an account?
                <a href="{{ route('register') }}" class="text-teal-600 hover:underline">Register Now!</a>
            </p>
        </div>
    </form>
</div>
