<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentsController extends Controller
{
    public function index() {
        $doc = request()->segment(2);
        $locale = app()->getLocale();

        $path = storage_path("app/documents/$doc/$locale.md");
        $file = File::get($path);

        $parsedown = new \Parsedown();
        $file = $parsedown->text($file);

        return view('terms', compact('file'));
    }
}
