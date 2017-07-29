<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\RefactorData;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class TransactionsController extends Controller
{
    use RefactorData;

    protected $visibleForAdmins = [
        'braintree_id'
    ];

    public function all(Payment $payment)
    {
        return Datatables::of(
            $this->refactorData(
                $this->getPayments($payment, [
                    'id', 'user_id', 'braintree_id', 'successful', 'amount', 'interest', 'created_at'
                ])
            )
        )->make(true);
    }

    public function failed(Payment $payment)
    {
        return Datatables::of(
            $this->refactorData(
                $this->getPayments($payment, [
                    'id', 'user_id', 'braintree_id', 'successful', 'amount', 'interest', 'created_at'
                ], [
                    ['successful', false]
                ])
            )
        )->make(true);
    }

    public function update(Payment $payment, Request $request)
    {
        $payment->update($request->only('successful'));

        return response(['status' => 'Row has been updated']);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response(['status' => 'Row has been deleted']);
    }

    protected function getPayments($payment, $select, $where = false)
    {
        if ($where) {
            return $payment->select($select)->where($where)->get()->makeVisible($this->visibleForAdmins);
        }
        return $payment->select($select)->get()->makeVisible($this->visibleForAdmins);
    }
}
