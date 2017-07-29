<?php

namespace App\Http\Requests\Admin;

use App\Jobs\SendMessage;
use App\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class ReplyForm extends FormRequest
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
            'body' => 'required',
            'locale' => 'required'
        ];
    }

    public function save($ticket)
    {
        $data = $this->intersect('body', 'locale');

        $subject = $this->intersect('subject');

        $subject = "{$subject['subject']} (Ref: {$ticket->unique_id})";

        $data['body'] = preg_replace('/&nbsp;/', ' ', $data['body']);
        $data['user_id'] = $this->user()->id;

        dispatch(new SendMessage(
            $data['body'], $subject, $ticket->user, $ticket->email, $data['locale']
        ));

        $ticket->reply()->create($data);

        $group = Ticket::getById($ticket->unique_id)->get();
        $group->each(function ($ticket) {
            $ticket->type = 2;
            $ticket->save();
        });
    }
}
