<?php

namespace App\Http\Requests;

use App\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class NewTicketForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'subject' => 'required|string|spamfree',
            'body' => 'required|spamfree'
        ];
    }

    public function save()
    {
        $data = $this->intersect(['email', 'subject', 'body']);
        $data['locale'] = app()->getLocale();
        $data['unique_id'] = getRandomString();

        if (auth()->check()) $data['user_id'] = auth()->user()->id;

        Ticket::create($data);
    }
}
