<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['item'];
}
