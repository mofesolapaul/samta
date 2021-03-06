@extends('layouts.app')

@section('title', "My account")
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
            @if($transactions->count())
                <table class="uk-table uk-table-hover uk-table-divider">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Account</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            @php ($data = cherrypickRelevantTransactionDetails($transaction, $account))
                            <td>{{ $data['date'] }}</td>
                            <td>
                                <span class="uk-label uk-label-{{ $data['originator'] ? 'warning':'success' }}">
                                    {{ $data['originator'] ? 'debit':'credit' }}
                                </span>
                            </td>
                            <td>{{ $data['amount'] }}</td>
                            <td>{{ $data['account'] }}</td>
                            <td title="{{ $data['status'] }}">
                                <span uk-icon="{{ $transaction->status ? 'check':'close' }}"></span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $transactions->links() }}
            @else
                <p>You have not made any transaction yet</p>
            @endif
            <a class="uk-button uk-button-primary" href="{{ route('account.send', $account) }}">
                Send Money
            </a>
        </div>
    </div>

@endsection
