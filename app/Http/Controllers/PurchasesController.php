<?php

namespace App\Http\Controllers;

use App\GlobalSettings;
use App\Http\Requests\WalletForm;
use App\Payment;
use App\User;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('interkassa');

        $this->middleware('construct-payments');
    }

    public function index()
    {
        return auth()->user()->payments()->paginate(7);
    }
    
    public function store(WalletForm $form)
    {
        try {
            $form->save();
        } catch (\Exception $e) {
            return response()->json(
                ['value' => [$e->getMessage()]], 422
            );
        }

        return [
            'status' => 'Success'
        ];
    }

    public function interkassa(Request $request)
    {
        $data = $request->only('ik_inv_id', 'ik_inv_st', 'ik_am', 'ik_x_user', 'ik_cur');

        if ($data['ik_cur'] != 'USD') return response(['status' => 'Only USD'], 422);

        $payment = [];
        $user = User::find($data['ik_x_user']);

        $payment['user_id'] = $user->id;
        $payment['payment_id'] = $data['ik_inv_id'];
        $payment['successful'] = ($data['ik_inv_st'] == 'success') ? 1 : 0;
        $payment['amount'] = round($data['ik_am'] * (100/120), 2);
        $payment['interest'] = round($data['ik_am'] * (20/120), 2);

        Payment::create($payment);

        if ($data['ik_inv_st'] == 'success') {
            $user->balance += $data['ik_am'] * (100/120);
            $user->save();
        }

        return response(['status' => 'Payment recorded']);
    }

    public function makeForm(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required'
        ]);

        $amount = $request->amount;
        $commission = GlobalSettings::getSettings('commissions')->data['value']['INTERKASSA'];

        $amount = round($amount * (1 + $commission / 100), 2);

        return [
            'ik_co_id' => '596b7c813b1eafc71c8b456c',
            'ik_pm_no' => 'ID_4233',
            'ik_am' => $amount,
            'ik_cur' => 'USD',
            'ik_desc' => 'Wallet Top Up',
            'ik_x_user' => $request->user()->id
        ];
    }

    public function token()
    {
        return response()->json([
            'token' => \Braintree_ClientToken::generate(),
        ]);
    }
}
