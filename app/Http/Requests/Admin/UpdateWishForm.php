<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWishForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ($this->user() && $this->user()->isAdmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item' => 'nullable|string',
            'current_amount' => 'nullable|numeric',
            'amount_needed' => 'nullable|numeric',
            'validated' => 'nullable',
            'completed' => 'nullable',
            'translations.ru.item' => 'nullable',
            'translations.en.item' => 'nullable',
        ];
    }

    public function save($wish)
    {
        $params = $this->intersect(['item', 'initial_amount', 'current_amount', 'amount_needed', 'translations']);

        $address = collect($this->intersect('address'))->map(function ($item) {
            return collect($item)->filter(function ($data) {
                return !is_null($data);
            })->only(['address_one', 'address_two', 'city', 'post_code', 'country']);
        })->toArray();

        $bool = collect($this->only(['validated', 'completed', 'processed']))->map(function ($item) {
            if (is_null($item)) return $item;
            elseif ($item == '0') return false;
            else return true;
        })->filter(function ($item) {
            return !is_null($item);
        })->toArray();

        $params = setTranslations($params);

        $data = array_merge($params, $bool);

        if (!empty($address)) {
            $data['address'] = array_merge($wish->address, $address['address']);
        }

        $wish->update($data);

        return response(['status' => 'Updated Successfully']);
    }
}
