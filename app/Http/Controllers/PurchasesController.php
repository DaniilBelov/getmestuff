<?php

namespace App\Http\Controllers;

use App\GlobalSettings;
use App\Payment;
use App\User;
use App\PayPal;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['interkassa', 'paypal']);

        $this->middleware('construct-payments');
    }

    public function index()
    {
        return auth()->user()->payments()->paginate(7);
    }

    public function interkassaForm($amount, $user_id)
    {
        return [
            'ik_co_id' => '596b7c813b1eafc71c8b456c',
            'ik_pm_no' => 'ID_4233',
            'ik_am' => $amount,
            'ik_cur' => 'RUB',
            'ik_desc' => 'Wallet Top Up',
            'ik_x_user' => $user_id
        ];
    }

    private function paypalForm($amount, $user_id)
    {
        return [
            'cmd' => '_xclick',
            'amount' => $amount,
            'business' => 'getmestuff.business-facilitator@gmail.com',
            'notify_url' => 'http://8f9aeb15.ngrok.io/en/paypal/success',
            'currency_code' => 'USD',
            'no_shipping' => '1',
            'custom' => $user_id,
            'return' => 'http://8f9aeb15.ngrok.io/home',
            'item_name' => 'GetMeStuff | Account Top Up'
        ];
    }

    public function makeForm(Request $request)
    {
        $request->segment(2);

        $this->validate($request, ['amount' => 'required']);
        $commission = GlobalSettings::getSettings('commissions')->data['value']['INTERKASSA'];
        $amount = round($request->amount * (1 + $commission / 100), 2);

        if ($request->segment(2) == 'paypal') return $this->paypalForm($amount, $request->user()->id);
        else return $this->interkassaForm($amount, $request->user()->id);
    }

    public function interkassa(Request $request)
    {
        if ($data['ik_cur'] != 'USD') return response(['status' => 'Only USD'], 422);

        $user = User::find($data['ik_x_user']);
        Payment::recordTransaction($user->id, $request->ik_inv_id, $request->ik_inv_st, $request->ik_am);

        if ($request->ik_inv_id == 'success') $user->increment('balance', ($request->ik_am * (100 / 120)));

        return response(['status' => 'Payment recorded']);
    }

    public function paypal(Request $request)
    {
        $ipn = new PayPal();
        $ipn->useSandbox();
        $verified = $ipn->verifyIPN();

        if ($verified) {
            if ($request->receiver_email != 'getmestuff.business-facilitator@gmail.com') return response(200);

            $user = User::find($request->custom);
            Payment::recordTransaction($user->id, $request->txn_id, $request->payment_status, $request->payment_gross);

            if ($request->payment_status == 'Completed') $user->increment('balance', ($request->payment_gross * (100 / 120)));
        }

        return response(200);
    }
}
