<?php

namespace App\Http\Controllers;

use App\Account;
use App\Exceptions\Currency\ExchangeRatesException;
use App\Exceptions\TransferException;
use App\Repository\AccountRepository;
use App\Repository\CurrencyRepository;
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
    public function create(CurrencyRepository $currencyRepository)
    {
        return view('account.create', [
            'currencies' => $currencyRepository->getAllCurrenciesInSimpleArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param AccountService $accountService
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AccountService $accountService)
    {
        $request->validate([
            'currency' => 'required|exists:currencies,code',
        ]);
        $account = $accountService->createNewAccount(\Auth::user()->id, $request->request->get('currency'));
        return redirect()->route('account.show', $account)->with([
            'success' => __('accounts.new_account_created', ['currency' => $request->request->get('currency')])
        ]);
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

    /**
     * @param Account $account
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function sendMoney(Account $account)
    {
        $this->authorize('view', $account);
        return view('account.send', [
            'account' => $account,
        ]);
    }

    /**
     * @param Request $request
     * @param Account $account
     * @param AccountService $accountService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function transfer(Request $request, Account $account, AccountService $accountService)
    {
        $this->authorize('view', $account);
        $request->validate([
            'receiver' => 'required|max:8|exists:accounts,account_number',
            'amount' => 'required|numeric|min:1.00'
        ]);
        try {
            $accountService->performAccountToAccountTransfer($account,
                Account::where(['account_number' => $request->request->get('receiver')])->first(),
                $request->request->get('amount'));
        } catch (TransferException $e) {
            return redirect()->back()->withInput()->with([
                'message' => $e->getMessage()
            ]);
        } catch (ExchangeRatesException $e) {
        }
        return redirect()->back()->with(['success' => __('accounts.transfer_successful')]);
    }
}
