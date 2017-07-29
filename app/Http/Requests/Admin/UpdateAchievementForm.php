<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAchievementForm extends FormRequest
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
            'need' => 'numeric|nullable',
            'prize' => 'numeric|nullable',
            'type' => 'numeric|nullable',
            'renew' => 'numeric|nullable',
            'translations.ru.title' => 'required',
            'translations.en.title' => 'required',
            'translations.ru.description' => 'required',
            'translations.en.description' => 'required',
        ];
    }

    public function save($achievement)
    {
        $info = $this->intersect(['translations', 'need', 'prize', 'type']);

        $renew = collect($this->only('renew'))->filter(function ($item) {
            return !is_null($item);
        })->toArray();

        $info = setTranslations($info);

        $dataSet = array_merge($info, $renew);

        $achievement->update($dataSet);
    }
}
