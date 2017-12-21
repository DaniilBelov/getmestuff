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
        $change = getPercentageChange($payments);

        return [
            'total' => $this->calculateProfit($payments),
            'this_month' => $this->calculateProfit($payments, 'month'),
            'today' => $this->calculateProfit($payments, 'today'),
            'inflow' => $this->calculateInflow($payments),
            'change' => $change
        ];
    }

    protected function calculateProfit($data, $when = false)
    {
        if ($when == 'month') $data = $this->month($data);
        elseif ($when == 'today') $data = $this->today($data);

        $interest = $data->sum(function ($item) {return $item->interest;});

        return number_format($interest, 2);
    }

    protected function calculateInflow($data)
    {
        $data = $this->month($data);
        $total = $data->sum(function ($item) {return $item->interest;}) + $data->sum(function ($item) {return $item->amount;});

        return number_format($total, 2);
    }

    protected function month($data)
    {
        return $data->filter(function ($item) {return $item->created_at->format('m-Y') == Carbon::now()->format('m-Y');});
    }

    protected function today($data)
    {
        return $data->filter(function ($item) {return $item->created_at->format('d-m-Y') == Carbon::now()->format('d-m-Y');});
    }
}
