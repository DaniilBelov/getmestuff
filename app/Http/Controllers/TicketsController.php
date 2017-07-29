<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewTicketForm;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function store(NewTicketForm $form)
    {
        $form->save();

        return response(['stauts' => 'Ticket created successfully']);
    }
}
