@extends('admin.layouts.admin')

@section('title', 'Create Achievement')

@section('header')
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/bower_components/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/bower_components/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page_title', 'Create Achievement')

@section('content')
    <tabs>
        <tab name="New Achievement" :selected="true">
            <create post="/admin/api/achievement/create"
                    :data="{
                together: [
                    { name: 'title', type: 'text', lang: true },
                    { name: 'description', type: 'textarea', lang: true },
                ],
                line: [
                    { name: 'refresh', type: 'select', options: {none: 0, monthly: 1, instant: 2} },
                    { name: 'type', type: 'text' },
                    { name: 'need', type: 'number' },
                    { name: 'reward', type: 'number' }
                ],
            }"></create>
        </tab>
        <tab name="New Prize">
            <create post="/admin/api/prize/create"
                    :data="{
                together: [
                    { name: 'item', type: 'text', lang: true },
                    { name: 'description', type: 'textarea', lang: true },
                ],
                line: [
                    { name: 'price', type: 'number' },
                    { name: 'user_column', type: 'text' },
                ],
            }"></create>
        </tab>
    </tabs>
@endsection

@section('scripts')
    <script src="{{ asset('admin/plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
@endsection