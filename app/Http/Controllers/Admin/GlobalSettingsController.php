<?php

namespace App\Http\Controllers\Admin;

use App\GlobalSettings;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GlobalSettingsController extends Controller
{
    public function search(GlobalSettings $setting, Request $request)
    {
        return collect(
            preg_grep("/{$request->search}/i", $setting->data)
        )->flatten();
    }

    public function destroy(GlobalSettings $setting, Request $request)
    {
        if ($setting->id == 6) User::unban($request->item);

        $data = $setting->data;
        $key = array_search($request->item, $data);
        array_forget($data, $key);
        $setting->data = $data;
        $setting->save();

        return response(['status' => 'Item deleted successfully']);
    }

    public function update(GlobalSettings $setting, Request $request)
    {
        $this->validate($request, [
            'item' => 'required|string|uniquearray:5'
        ]);

        if ($setting->id == 6) User::ban($request->item);

        $data = $setting->data;
        array_push($data, $request->item);
        $setting->data = $data;
        $setting->save();

        return response(['status' => 'Item added successfully']);
    }

    public function changeState(GlobalSettings $setting, Request $request)
    {
        $data = $setting->data;

        $data['on'] = $request->state;

        $setting->data = $data;
        $setting->save();

        return response(['status' => 'State updated']);
    }

    public function changeValue(GlobalSettings $setting, Request $request)
    {
        $this->validate($request, [
            'value' => $this->condValidation($request->value)
        ]);

        $data = $setting->data;

        if (is_null($request->key)) {
            $data['value'] = $request->value;
        } else {
            $data['value'][$request->key] = $request->value;
        }

        $setting->data = $data;
        $setting->save();

        return response(['status' => 'Value has been updated']);
    }

    public function condValidation($value)
    {
        if (is_numeric($value)) {
            return 'required|numeric|min:1';
        } else {
            return'required|string|min:1';
        }
    }
}
