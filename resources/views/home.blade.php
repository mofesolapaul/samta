@extends('layouts.app')

@section('content')

    <div class="uk-section">
        <div class="uk-container uk-container-expand uk-width-1-2@m uk-align-center">

            <div class="uk-card uk-card-primary uk-card-body">
                <h3 class="uk-card-title">Welcome, {{ Auth::user()->name }}</h3>
                <p>You
                    have {{ trans_choice('accounts.number_of_accounts', ['count' => Auth::user()->accounts->count()]) }}</p>
            </div>

            <p>
                <a class="uk-button uk-button-default" href="{{ route('account.create') }}">
                    <span uk-icon="plus"></span>
                    Create New Account
                </a>
            </p>
        </div>
    </div>

@endsection
