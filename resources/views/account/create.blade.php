@extends('layouts.app')

@section('title', "Add new account")
@section('content')

    <div class="uk-section">
        <div class="uk-container uk-container-expand uk-width-1-2@m uk-align-center">
            <div class="uk-card uk-card-secondary uk-card-body">
                <h3 class="uk-card-title">
                    You
                    have {{ trans_choice('accounts.number_of_accounts', Auth::user()->accounts->count()) }}
                </h3>
            </div>
            <h3 class="uk-heading-bullet">Add new account</h3>
            <form class="uk-form-stacked" role="form" method="POST" action="{{ route('account.store') }}">
                {{ csrf_field() }}
                {!!
                    Form::select('currency', 'What currency would you like your new account in?', $currencies)
                        ->attrs([
                            'required' => true,
                        ])
                !!}
                {!! Form::submit("Create")->attrs(['class' => 'uk-button-primary']) !!}
            </form>
        </div>
    </div>

@endsection
