<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrizeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['item', 'description'];
}
