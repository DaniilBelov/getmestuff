@extends('admin.layouts.admin')

@section('title', 'Wishes Settings')

@section('header')
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/bower_components/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/bower_components/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page_title', 'Wishes Settings')

@section('content')
    <settings :data="{{ $settings }}"
              :search="['word_replacements']"
              post="/admin/api/wishes/settings">
    </settings>
@endsection

@section('scripts')
    <script src="{{ asset('admin/plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            $(".select2").select2();
            $('.selectpicker').selectpicker();
            // For multiselect
            $('#pre-selected-options').multiSelect();
            $('#optgroup').multiSelect({
                selectableOptgroup: true
            });
            $('#public-methods').multiSelect();
            $('#select-all').click(function () {
                $('#public-methods').multiSelect('select_all');
                return false;
            });
            $('#deselect-all').click(function () {
                $('#public-methods').multiSelect('deselect_all');
                return false;
            });
            $('#refresh').on('click', function () {
                $('#public-methods').multiSelect('refresh');
                return false;
            });
            $('#add-option').on('click', function () {
                $('#public-methods').multiSelect('addOption', {
                    value: 42
                    , text: 'test 42'
                    , index: 0
                });
                return false;
            });
        });
    </script>
@endsection