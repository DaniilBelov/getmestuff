<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserFrom extends FormRequest
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
        $data = $this->intersect(['first_name', 'last_name', 'email', 'ip_address', 'ref_link']);

        $balance = collect($this->only(['balance']))->filter(function ($item) {
            return !is_null($item);
        })->toArray();

        $bool = collect($this->only(['verified', 'donated', 'admin']))->map(function ($item) {
            return ($item == '1');
        })->toArray();

        if (isset($data['ip_address'])) {
            $data['ip_address'] = ip2long($data['ip_address']);
        }

        $dataSet = $data + $balance + $bool;

        $user->update($dataSet);
    }
}
