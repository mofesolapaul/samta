@extends('layouts.app')

@section('content')

    <div class="uk-section">
        <div class="uk-container uk-container-expand uk-width-1-2@m uk-align-center">
            <div class="uk-card uk-card-primary uk-card-body">
                <h3 class="uk-card-title">
                    {!! $account->currency->code . ': ' . format_account_number($account->account_number) !!}
                </h3>
            </div>
        </div>
    </div>

@endsection
