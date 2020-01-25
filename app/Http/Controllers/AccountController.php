<?php

namespace App\Http\Controllers;

use App\Account;
use App\Exceptions\TransferException;
use App\Repository\AccountRepository;
use App\Services\AccountService;
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
        return view('account.send', [
            'account' => $account,
        ]);
    }

    /**
     * @param Request $request
     * @param Account $account
     * @param AccountService $accountService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer(Request $request, Account $account, AccountService $accountService)
    {
        $request->validate([
            'receiver' => 'required|max:8|exists:accounts,account_number',
            'amount' => 'required|numeric'
        ]);
        try {
            $accountService->performAccountToAccountTransfer($account,
                Account::where(['account_number' => $request->request->get('receiver')])->first(),
                $request->request->get('amount'));
        } catch (TransferException $e) {
            return redirect()->back()->withInput()->with([
                'message' => $e->getMessage()
            ]);
        }
        return redirect()->back()->with(['success' => __('accounts.transfer_successful')]);
    }
}
