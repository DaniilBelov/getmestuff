<?php

namespace App\Http\Requests;

use App\Events\UserHasDonated;
use App\Jobs\NotifyUser;
use App\Wish;
use Illuminate\Foundation\Http\FormRequest;

class DonateForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:0.01'
        ];
    }

    public function save($wish)
    {
        if ($wish->completed == 1) {
            $message = getErrorMessage(
                'This wish is already completed, please choose another or refresh the page.',
                'Это желание уже исполнено, пожалуйста выберете другое или перезагрузить страницу.');
            throw new \Exception($message);
        }
        $diff = ($wish->amount_needed) - ($wish->current_amount);

        if (($this->amount > $this->user()->balance) || ($this->amount > $diff))
        {
            $message = getErrorMessage('You cannot donate this amount.', 'Вы не можете пожертвовать эту сумму.');
            throw new \Exception($message);
        }

        event(new UserHasDonated($this->user(), $this->amount));
        dispatch(new NotifyUser($wish, $this->amount));

        $this->user()->donate($wish, $this->amount);
    }
}
