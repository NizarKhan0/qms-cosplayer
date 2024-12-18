<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>

    <header class="page-topbar" id="header">
        <div class="navbar navbar-fixed">
            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-light">
                <div class="nav-wrapper">

                    <ul class="navbar-list right">
                        <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen"
                                href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
                        {{-- <li class="hide-on-large-only search-input-wrapper"><a
                                class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i
                                    class="material-icons">search</i></a></li> --}}
                        {{-- <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);"
                                data-target="profile-dropdown"><span class="avatar-status avatar-online"><img
                                        src="{{ asset('template/assets/app-assets/images/avatar/avatar-7.png') }}"
                                        alt="avatar"><i></i></span></a></li> --}}
                    </ul>

                    <!-- profile-dropdown-->
                    {{-- <ul class="dropdown-content" id="profile-dropdown">
                        <li><a wire:navigate class="grey-text text-darken-1" href="{{ route('profile') }}"><i
                                    class="material-icons">person_outline</i> Profile</a></li>
                        <li><a class="grey-text text-darken-1" href="app-chat.html"><i
                                    class="material-icons">chat_bubble_outline</i> Chat</a></li>
                        <li class="divider"></li>
                        <li>
                            <a class="grey-text text-darken-1" wire:click="logout">
                                <i class="material-icons">keyboard_tab</i> Logout
                            </a>
                        </li>
                    </ul> --}}
                </div>

            </nav>
        </div>
    </header>


</div>
