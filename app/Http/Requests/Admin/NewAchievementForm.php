<?php

namespace App\Http\Requests\Admin;

use App\Achievement;
use Illuminate\Foundation\Http\FormRequest;

class NewAchievementForm extends FormRequest
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
            'en.title' => 'required|string|min:1',
            'en.description' => 'required|string|min:1',
            'ru.title' => 'required|string|min:1',
            'ru.description' => 'required|string|min:1',
            'need' => 'required|numeric|min:1',
            'reward' => 'required|numeric|min:1',
            'refresh' => 'required|numeric',
            'type' => 'required|numeric'
        ];
    }

    public function save()
    {
        $set = [];
        $data = $this->only(['en', 'ru', 'need', 'reward', 'refresh', 'type']);

        $set['en']['title'] = $data['en']['title'];
        $set['ru']['title'] = $data['ru']['title'];
        $set['en']['description'] = $data['en']['description'];
        $set['ru']['description'] = $data['ru']['description'];
        $set['need'] = $data['need'];
        $set['prize'] = $data['reward'];
        $set['renew'] = $data['refresh'];
        $set['type'] = $data['type'];

        Achievement::create($set);
    }
}
