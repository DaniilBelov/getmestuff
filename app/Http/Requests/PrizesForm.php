<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mockery\CountValidator\Exception;
use App\Prize;

class PrizesForm extends FormRequest
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
            'quantity' => 'required|numeric|min:1',
            'selected' => 'required'
        ];
    }

    public function save() {
        $prize = Prize::find($this->selected);

        $quantity = $this->quantity;
        if ($this->selected == 3) {
            $quantity = 1;
        }

        $price = $prize->price * $quantity;

        if ($price > $this->user()->points) {
            $message = getErrorMessage('You don\'t have enough point.', 'У вас не достаточно очков');
            throw new Exception($message);
        }

        if ($this->selected == 3 && $this->user()->allowed_wishes != 0) {
            $message = getErrorMessage('You already have maximum limit.', 'У вас уже максимальный лимит.');
            throw new \Exception($message);
        }

        $column = $prize->user_column;

        $this->user()->$column += $quantity;
        $this->user()->points -= $price;

        $this->user()->save();
    }
}
