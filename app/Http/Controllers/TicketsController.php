<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewTicketForm;
use App\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function store(NewTicketForm $form)
    {
        $form->save();

        return response(['stauts' => 'Ticket created successfully']);
    }

    public function mailgun(Request $request)
    {
        $data = $request->intersect(['sender', 'subject', 'stripped-text']);

        $this->create($data);
    }

    protected function create($email)
    {
        $data = [];

        list($subject, $unique_id) = getUniqueId($email['subject']);

        if (!$unique_id) {
            $unique_id = getRandomString();
        } else {
            $ticket = Ticket::getById($unique_id)->latest()->first();
            $data['priority'] = $ticket->priority;
        }

        \Log::info($unique_id);

        $data['unique_id'] = $unique_id;
        $data['email'] = $email['sender'];
        $data['subject'] = $subject;
        $data['body'] = $email['stripped-text'];

        Ticket::create($data);
    }
}
