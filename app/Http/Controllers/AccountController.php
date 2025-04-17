<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountStoreRequest;
use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $accounts = Account::all();

        return view('account.index', [
            'accounts' => $accounts,
        ]);
    }

    public function store(AccountStoreRequest $request): RedirectResponse
    {
        $account = Account::create($request->validated());

        return redirect()->route('account.index');
    }
}
