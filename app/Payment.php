<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'payment_id', 'successful', 'amount', 'interest', 'deleted_wish'
    ];

    protected $hidden = [
        'payment_id', 'deleted_wish'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function recordTransaction($userId, $payment_id, $successful, $amount)
    {
         return static::create([
                    'user_id' => $userId,
                    'payment_id' => $payment_id,
                    'successful' => ($successful == 'success' || $successful == 'Completed') ? 1 : 0,
                    'amount' => round($amount * (100 / 120), 2),
                    'interest' => round($amount * (20 / 120), 2)
                ]);
    }

    public function getData()
    {
        $payments = $this->where('successful', true)->get();
        $change = $change = getPercentageChange($payments);

        $total = $this->calculateProfit($payments);
        $this_month = $this->calculateProfit($payments, 'month');
        $today = $this->calculateProfit($payments, 'today');

        return [
            'total' => $total,
            'this_month' => $this_month,
            'today' => $today,
            'change' => $change
        ];
    }

    protected function calculateProfit($data, $when = false)
    {
        if ($when == 'month') {
            $data = $data->filter(function ($item) {
                return $item->created_at->format('m-Y') == Carbon::now()->format('m-Y');
            });
        } elseif ($when == 'today') {
            $data = $data->filter(function ($item) {
                return $item->created_at->format('d-m-Y') == Carbon::now()->format('d-m-Y');
            });
        }

        $deleted = $data->filter(function ($item) {
            return !is_null($item->deleted_wish);
        });

        $data = $data->filter(function ($item) {
            return $item->amount != 0;
        });

        $amount = $data->sum(function ($item) {return $item->amount;});
        $interest = $data->sum(function ($item) {return $item->interest;});
        $count = $data->count();

        $total = $amount + $interest;

        $profit = ($total) - ($total * 0.019 + (.20 * $count)) - $amount;

        return number_format($profit, 2);
    }
}
