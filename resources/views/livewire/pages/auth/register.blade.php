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
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    @section('title', 'Register')
    <form wire:submit="register">

        <div class="row">
            <div class="input-field col s12">
                <h5 class="ml-4">Register</h5>
                <p class="ml-4">Join to our community now !</p>
            </div>
        </div>

        <div class="row margin">
            <!-- Name -->
            <div class="input-field col s12">
                <i class="pt-2 material-icons prefix">person_outline</i>
                {{-- <input id="name" type="text">
                <label for="name" class="center-align">Name</label> --}}
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input wire:model="name" id="name" class="block w-full mt-1" type="text" name="name"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="row margin">
            <div class="input-field col s12">
                <i class="pt-2 material-icons prefix">mail_outline</i>
                {{-- <input id="email" type="email">
                <label for="email">Email</label> --}}
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="row margin">
            <div class="input-field col s12">
                <i class="pt-2 material-icons prefix">lock_outline</i>
                {{-- <input id="password" type="password">
                <label for="password">Password</label> --}}
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input wire:model="password" id="password" class="block w-full mt-1" type="password"
                    name="password" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="row margin">
            <div class="input-field col s12">
                <i class="pt-2 material-icons prefix">lock_outline</i>
                {{-- <input id="password-again" type="password">
                <label for="password-again">Password again</label> --}}
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block w-full mt-1"
                    type="password" name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <button type="submit"
                    class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Register</button>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <p class="margin medium-small"><a href="{{ route('login') }}">Already have an account? Login</a></p>
            </div>
        </div>
    </form>
</div>
