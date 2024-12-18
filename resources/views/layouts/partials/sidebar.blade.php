<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark sidenav-active-rounded">
    <div class="brand-sidebar">
        {{-- <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="JavaScript:void(0)"><img class="hide-on-med-and-down "
                    src="{{ asset('template/assets/app-assets/images/logo/materialize-logo.png') }}"
                    alt="materialize logo"><img class="show-on-medium-and-down hide-on-med-and-up"
                    src="{{ asset('app-assets/images/logo/materialize-logo.png') }}" alt="materialize logo"><img
                    class="show-on-medium-and-down hide-on-med-and-up"
                    src="{{ asset('template/assets/app-assets/images/logo/materialize-logo.png') }}" alt="materialize logo"><span
                    class="logo-text hide-on-med-and-down">Materialize</span></a><a class="navbar-toggler"
                href="#"><i class="material-icons">radio_button_checked</i></a></h1> --}}

        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="JavaScript:void(0)"><img class="hide-on-med-and-down "
                    src="{{ asset('template/assets/app-assets/images/logo/materialize-logo.png') }}"
                    alt="materialize logo"><span class="logo-text hide-on-med-and-down">Materialize</span></a><a
                class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
    </div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out"
        data-menu="menu-navigation" data-collapsible="accordion">
        {{-- <li class="active bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">Dashboard</span><span class="float-right mr-10 badge pill orange">3</span></a>
        <div class="collapsible-body">
          <ul class="collapsible collapsible-sub" data-collapsible="accordion">
            <li><a href="{{ route('dashboard') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Modern">Modern</span></a>
            </li>
          </ul>
        </div>
      </li> --}}
        <li class="bold"><a class="waves-effect waves-cyan " href="{{ route('dashboard') }}"><i
                    class="material-icons">settings_input_svideo</i><span class="menu-title"
                    data-i18n="Dashboard">Dashboard</span></a>
        </li>
        <li class="navigation-header"><a class="navigation-header-text">Features </a><i
                class="navigation-header-icon material-icons">more_horiz</i>
        </li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i
                    class="material-icons">face</i><span class="menu-title" data-i18n="User">Manage Users</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                    {{-- untuk assign by role_id = 1 = superadmin --}}

                    @if (Auth::user()->role_id === 1)
                        <li><a href="{{ route('all-users') }}"><i class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="List">List Users</span></a>
                        </li>
                        <li><a href="{{ route('all-cosplayers') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span data-i18n="List">List
                                    Cosplayers</span></a>
                        </li>
                        <li><a href="{{ route('all-fans') }}"><i class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="List">List Fans</span></a>
                        </li>
                    @else
                        <li><a href="{{ route('all-fans') }}"><i class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="List">List Fans</span></a>
                        </li>
                    @endif

                </ul>
            </div>
        </li>

        <li class="bold"><a class="waves-effect waves-cyan " href="{{ route('profile') }}"><i
                    class="material-icons">person_outline</i><span class="menu-title" data-i18n="User Profile">User
                    Profile</span></a>
        </li>

    </ul>
    <div class="navigation-background"></div><a
        class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only"
        href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
