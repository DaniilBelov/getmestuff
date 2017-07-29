<?php

namespace App;

use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    use Translatable;

    public $translatedAttributes = ['item'];

    protected $fillable = [
        'user_id', 'url', 'initial_amount', 'current_amount',
        'amount_needed', 'address', 'donated', 'completed',
        'priority', 'validated', 'processed'
    ];

    protected $casts = [
        'address' => 'json'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'url', 'address', 'priority', 'validated', 'completed', 'donated', 'updated_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function (Wish $wish) {
            if ($wish->amount_needed == $wish->current_amount) {
                $wish->completed = 1;

                if ($wish->user->number_of_wishes == 0) {
                    $wish->user->increment('number_of_wishes');
                }
                return;
            }
        });

        static::deleting(function (Wish $wish) {
            $amount = $wish->current_amount - $wish->initial_amount;

            if ($wish->user->number_of_wishes == 0) {
                $wish->user->increment('number_of_wishes');
            }

            if ($amount != 0) {
                Payment::create([
                    'user_id' => $wish->user_id,
                    'payment_id' => 12345,
                    'successful' => true,
                    'amount' => 0,
                    'interest' => 0,
                    'deleted_wish' => $amount
                ]);
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recordDonation($user, $value)
    {
        $this->current_amount += $value;
        $donated = json_decode($this->donated, true);

        if (is_null($donated)) {
            $donated = [
                "amount.$value.user.$user.donated"
            ];
        } else {
            array_push($donated, "amount.$value.user.$user.donated");
        }

        $this->donated = json_encode($donated);

        $this->save();
    }

    public static function getWishes($id, $limit = 6, $ids = false)
    {
        $wishes = static::orderBy(\DB::raw('-LOG(1.0 - RAND()) / `priority`'))
            ->where('user_id', '!=', $id)
            ->where('completed', "!=", 1)
            ->where('validated', '=', 1)
            ->whereRaw(
                "(reported IS NULL OR reported NOT LIKE '%user.$id.report%') AND 
                (donated IS NULL OR donated NOT LIKE '%user.$id.donated%')"
            );

        if ($ids) {
            $wishes = $wishes->whereNotIn('id', $ids);
        }
        
        return $wishes->limit($limit)->get()->map(function ($item) {
            $item = collect($item);
            $item['current_amount'] = $item['current_amount'] + $item['initial_amount'];
            return $item;
        });
    }

    public function getWish($id, $ids)
    {
        return $this->orderBy(\DB::raw('-LOG(1.0 - RAND()) / `priority`'))
            ->where('user_id', '!=', $id)
            ->where('completed', "!=", 1)
            ->where('validated', '=', 0)
            ->whereNotIn('id', $ids)
            ->whereRaw("donated NOT LIKE '%user.$id.donated%' OR donated IS NULL AND reported NOT LIKE '%user.$id.report%' OR reported IS NULL")
            ->limit(1)
            ->get();
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function getData()
    {
        $wishes = $this->where('validated', '=', 1)->get();

        list($total, $completed, $in_progress) = $this->countWishes($wishes);
        $change = getPercentageChange($wishes);
        $outflow = $this->countOutflow($wishes);

        return [
            'total' => $total,
            'completed' => $completed,
            'in_progress' => $in_progress,
            'change' => $change,
            'outflow' => $outflow
        ];
    }

    protected function countWishes($wishes)
    {
        $total = $wishes->count();

        $completed = $wishes->filter(function ($item) {
            return $item->completed == 1;
        })->count();

        $in_progress = $wishes->filter(function ($item) {
            return $item->completed == 0;
        })->count();

        return [$total, $completed, $in_progress];
    }

    protected function countOutflow($wishes)
    {
        return $wishes->filter(function ($item) {
            return $item->completed == 1 && $item->created_at->format('m-Y') == Carbon::now()->format('m-Y');
        })->sum(function ($item) {
            return $item->amount_needed;
        });
    }
}
