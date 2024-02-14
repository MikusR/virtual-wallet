<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::with('user')->get();


        return view('wallets.index', ['wallets' => $wallets]);
    }

    public function create()
    {
        return view('wallets.create');
    }
}
