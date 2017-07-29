@extends('admin.layouts.admin')

@section('title', 'Reply')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}" />
@endsection

@section('page_title', 'Reply')

@section('content')
    <reply-to-ticket :tickets="{{ $tickets }}" :user="{{ auth()->user() }}"></reply-to-ticket>
@endsection

@section('scripts')
    <script src="{{ asset('admin/plugins/bower_components/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/html5-editor/wysihtml5-0.3.0.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/html5-editor/bootstrap-wysihtml5.js') }}"></script>
@endsection