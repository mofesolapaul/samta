@extends('layouts.app')

@section('title', "Send money")
@section('content')

    <div class="uk-section">
        <div class="uk-container uk-container-expand uk-width-1-2@m uk-align-center">
            <div class="uk-card uk-card-secondary uk-card-body">
                <h3 class="uk-card-title">
                    {!! $account->currency->code . ': ' . format_account_number($account->account_number) !!}
                    <small class="uk-text-small">Balance - {{ format_account_balance($account) }}</small>
                </h3>
            </div>
            <h3 class="uk-heading-bullet">Send Money</h3>
            <form class="uk-form-stacked" role="form" method="POST" action="{{ route('account.transfer', $account) }}">
                {{ csrf_field() }}
                {!!
                    Form::text('receiver', 'Receiving Account Number')
                        ->attrs([
                            'required' => true,
                            'placeholder' => '1234AMS',
                            'class' => 'masked',
                            'pattern' => '\d{4}\w{3}',
                            'data-charset' => 'XXXX___'
                        ])
                !!}
                {!! Form::text('amount', 'Amount')->type('number')->attrs(['max' => $account->balance, 'step' => 0.01]) !!}
                {!! Form::submit("Send")->attrs(['class' => 'uk-button-primary']) !!}
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/masking-input.js" data-autoinit="true"></script>
@endsection
