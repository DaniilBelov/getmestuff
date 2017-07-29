<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsForm;
use App\User;

class UserSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update (SettingsForm $form)
    {
        try {
            $form->save();
        } catch (\Exception $e) {
            return response()->json(
                ['message' => [$e->getMessage()]], 401
            );
        }

        return response(['status' => 'Settings Updated!']);
    }

    public function verify ($token, User $user)
    {
        $user->settings()->updateEmail($token);

        return redirect('/home');
    }
}
