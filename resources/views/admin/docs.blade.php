@extends('admin.layouts.admin')

@section('title', 'Documents')

@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <style>
        .CodeMirror-scroll {
            height: 500px
        }
    </style>
@endsection

@section('page_title', 'Documents')

@section('content')
    <tabs>
        <tab name="English" :selected="true">
            <markdown doc="{{ $document }}" name="en" value="{{ $eng }}"></markdown>
        </tab>
        <tab name="Russian">
            <markdown doc="{{ $document }}" name="ru" value="{{ $rus }}"></markdown>
        </tab>
    </tabs>
@endsection

@section('scripts')
@endsection

{{--  <html>
    <head>
        <title>Hello</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    </head>
    <body>
        <textarea id="editor">{{ $file }}</textarea>
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script>
            var simplemde = new SimpleMDE({ 
                element: document.getElementById("editor") 
            });
        </script>
    </body>
</html>  --}}