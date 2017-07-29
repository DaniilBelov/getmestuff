<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserActivityFrom extends FormRequest
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
            //
        ];
    }

    public function save($user)
    {
        $data = $this->intersect(['first_name', 'last_name', 'ref_link']);
        $balance = collect($this->only(
            ['balance', 'number_of_wishes', 'priority', 'amount_donated', 'amount_received', 'points']
        ))->filter(function ($item) {
            return !is_null($item);
        })->toArray();

        $dataSet = $data + $balance;

        $user->update($dataSet);
    }
}
