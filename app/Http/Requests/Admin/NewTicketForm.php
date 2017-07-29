<?php

namespace App\Http\Requests\Admin;

use App\Jobs\SendMessage;
use App\Mail\Message;
use App\Ticket;
use App\User;
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
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'users' => 'required',
            'priority' => 'required',
            'subject' => 'required',
            'body' => 'required'
        ];
    }

    public function save()
    {
        $users = User::find($this->only('users')['users']);

        $users->each(function ($user) {
            $data = $this->only('priority', 'subject', 'body');
            $unique_id = getRandomString();

            $subject = "{$data['subject']} (Ref: {$unique_id})";

            $data['unique_id'] = $unique_id;
            $data['email'] = $user->email;
            $data['user_id'] = $user->id;
            $data['is_admin'] = true;
            $data['locale'] = $user->locale;

            Ticket::create($data);

            dispatch(new SendMessage($this->user(), $data['body'], $subject, $user));
        });
    }
}
