<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use Translatable;

    public $translatedAttributes = ['item', 'description'];
    protected $fillable = [
        'price', 'bought', 'user_column'
    ];
}
