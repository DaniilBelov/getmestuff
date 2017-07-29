<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function switchLang($language, Request $request)
    {
        $prev_url = url()->previous();
        $previous_request = $request->create($prev_url);
        $segments = $previous_request->segments();

        if (in_array($language, config('translatable.locales'))) {
            $segments[0] = $language;

            return redirect()->to(implode('/', $segments));
        }

        return back();
    }
}
