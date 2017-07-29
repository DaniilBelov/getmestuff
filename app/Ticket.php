<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpImap\Mailbox;

class Ticket extends Model
{
    protected $emails = [];

    protected $fillable = [
        'unique_id', 'email', 'subject', 'body', 'priority', 'type', 'user_id', 'is_admin', 'locale'
    ];

    public function checkEmails()
    {
        $emails = [];
        $mailbox = new Mailbox(
            '{imap.gmail.com:993/imap/ssl}INBOX',
            'daniil.belov07@gmail.com',
            'Daniil89917032'
        );

        $mailsIds = $mailbox->searchMailbox('UNSEEN');

        if (!$mailsIds) {
            return false;
        }

        collect($mailsIds)->each(function ($item) use ($mailbox) {
            $this->emails[] = $this->refactorEmailData($mailbox->getMail($item));
        });

        return $this->emails;
    }

    protected function refactorEmailData($email)
    {
        $data = [];

        list($subject, $unique_id) = getUniqueId($email->subject);

        if (!$unique_id) {
            $unique_id = getRandomString();
        }

        $data['unique_id'] = $unique_id;
        $data['email'] = $email->fromAddress;
        $data['subject'] = $subject;
        $data['body'] = $email->textPlain;

        return $data;
    }

    public function scopeGetById($query, $id)
    {
        return $query->where('unique_id', $id);
    }

    public function reply()
    {
        return $this->hasOne(Reply::class);
    }
}
