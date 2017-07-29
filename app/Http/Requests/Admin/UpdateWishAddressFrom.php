<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWishAddressFrom extends FormRequest
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
            //
        ];
    }

    public function save($wish)
    {
        $address = collect($this->intersect('address'))->map(function ($item) {
            return collect($item)->filter(function ($data) {
                return !is_null($data);
            })->only(['address_one', 'address_two', 'city', 'post_code', 'country']);
        })->toArray();

        $updateWish['address'] = array_merge($wish->address, $address['address']);
        $updateWish = array_merge($updateWish, $this->intersect('item'));

        $wish->update($updateWish);
    }
}
