<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Samta - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @if(session()->has('message'))
        <div class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session()->get('message') }}</p>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session()->get('success') }}</p>
        </div>
    @endif

    @auth
        <div id="offcanvas-slide" uk-offcanvas="mode: slide; overlay: true;">
            <div class="uk-offcanvas-bar">
                <button class="uk-offcanvas-close" type="button" uk-close></button>
                <h3>My Accounts</h3>
                <ul class="uk-list uk-list-striped">
                    @foreach(Auth::user()->accounts as $index => $account)
                        <li>
                            <a href="{{ route('account.show', ['id' => $account->id]) }}">
                                <div>
                                    {!!
                                       $index + 1 . '. ' .
                                       format_account_number($account->account_number) .' ('.
                                       format_account_balance($account) . ')'
                                    !!}
                                </div>
                            </a>
                        </li>
                    @endforeach
                    <p>
                        <a class="uk-button uk-button-secondary" href="{{ route('account.create') }}">
                            Add New Account
                        </a>
                    </p>
                </ul>
            </div>
        </div>
    @endauth

    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
        <div class="uk-box-shadow-medium uk-navbar-container uk-navbar-primary" uk-navbar="mode: click">
            <div class="uk-container uk-container-expand uk-width-1-1">

                <nav class="uk-navbar">

                    <div class="uk-navbar-left">
                        <!-- Branding Image -->
                        <span class="uk-navbar-item" href="{{ url('/') }}">
                            <span class="uk-button uk-button-default uk-margin-small-right" uk-icon="menu"
                                  uk-toggle="target: #offcanvas-slide" type="button"></span> &nbsp;
                            <a class="uk-logo">Samta</a>
                        </span>
                    </div>

                    <div class="uk-navbar-right">
                        <ul class="uk-navbar-nav">
                            @if (Auth::guest())
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                                <li>
                                    <a href="#" uk-icon="icon: user; ratio: 2" title="{{ Auth::user()->name }}"></a>
                                    <div class="uk-navbar-dropdown">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li>
                                                <a href="{{ route('home') }}">Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                      style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>

                </nav>

            </div>
        </div>
    </div>

    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js');
</body>
</html>
