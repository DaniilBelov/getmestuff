<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index($document)
    {
        $eng = storage_path("app/documents/{$document}/en.md");
        $rus = storage_path("app/documents/{$document}/ru.md");
        
        $eng = File::get($eng);
        $rus = File::get($rus);

        return view('admin.docs', compact('eng', 'rus', 'document'));
    }

    public function store(Request $request)
    {
        Storage::put("documents/{$request->type}/{$request->lang}.md", $request->document);

        return response(['status' => 'Success']);
    }
}
