<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpImap\Mailbox;

class Ticket extends Model
{
    protected $emails = [];

    protected $fillable = [
        'unique_id', 'email', 'subject', 'organisation',
        'body', 'priority', 'type', 'user_id', 'is_admin', 'locale'
    ];

    public function scopeGetById($query, $id)
    {
        return $query->where('unique_id', $id);
    }

    public function reply()
    {
        return $this->hasOne(Reply::class);
    }
}
