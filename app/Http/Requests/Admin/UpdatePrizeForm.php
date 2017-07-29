<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrizeForm extends FormRequest
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
            'user_column' => 'nullable',
            'price' => 'numeric|nullable',
            'translations.ru.item' => 'required',
            'translations.en.item' => 'required',
            'translations.ru.description' => 'required',
            'translations.en.description' => 'required',
        ];
    }

    public function save($prize)
    {
        $data = $this->intersect('translations', 'user_column', 'price');

        $data = setTranslations($data);

        $prize->update($data);
    }
}
