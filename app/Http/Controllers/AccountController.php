<?php

namespace App\Http\Controllers;

use App\Account;
use App\Repository\AccountRepository;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account $account
     * @param AccountRepository $accountRepository
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Account $account, AccountRepository $accountRepository)
    {
        $this->authorize('view', $account);
        return view('account.view', [
            'account' => $account,
            'transactions' => $accountRepository->getAllTransactions($account->id)
        ]);
    }

    public function sendMoney(Account $account)
    {
    }
}
