@extends('layouts.app')

@section('content')

    <div class="uk-section">
        <div class="uk-container uk-container-expand uk-width-1-2@m uk-align-center">
            <div class="uk-card uk-card-secondary uk-card-body">
                <h3 class="uk-card-title">
                    {!! $account->currency->code . ': ' . format_account_number($account->account_number) !!}
                    <small class="uk-text-small">Balance - {{ format_account_balance($account) }}</small>
                </h3>
            </div>
            <h3 class="uk-heading-bullet">All Transactions</h3>
            @forelse($transactions as $transaction)
            @empty
                <p>You have not made any transaction yet</p>
            @endforelse
            {{ $transactions->links() }}
            <a class="uk-button uk-button-primary" href="{{ route('account.send', $account) }}">
                Send Money
            </a>
        </div>
    </div>

@endsection
