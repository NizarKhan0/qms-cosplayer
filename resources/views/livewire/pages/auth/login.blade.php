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

    <form wire:submit="login">
        <div class="row">
            <div class="input-field col s12">
                <h5 class="ml-4">Sign in</h5>
            </div>
        </div>
        <div class="row margin">
            <div class="input-field col s12">
                <i class="pt-2 material-icons prefix">mail_outline</i>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email" class="block w-full mt-1" type="email" name="email"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>
        </div>
        <div class="row margin">
            <div class="input-field col s12">
                <i class="pt-2 material-icons prefix">lock_outline</i>
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input wire:model="form.password" id="password" class="block w-full mt-1" type="password"
                    name="password" required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>
        </div>
        <div class="row">
            <div class="mt-1 ml-2 col s12 m12 l12">
                <p>
                    <label>
                        <input wire:model="form.remember" id="remember" type="checkbox"
                            class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button type="submit"
                    class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Login</button>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6 m6 l6">
                <p class="margin medium-small"><a href="{{ route('register') }}">Register Now!</a></p>
            </div>
            <div class="input-field col s6 m6 l6">
                @if (Route::has('password.request'))
                    <p class="margin right-align medium-small"><a href="{{ route('password.request') }}"
                            wire:navigate>Forgot password ?</a></p>
                    </a>
                @endif
            </div>
        </div>
    </form>
    </div>
</div>
