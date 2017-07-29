@extends('admin.layouts.admin')

@section('title', 'General Settings')

@section('header')
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/bower_components/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/bower_components/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/plugins/bower_components/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page_title', 'General Settings')

@section('content')
    <settings :data="{{ $settings }}"
              :search="['banned_words']"
              post="/admin/api/settings"
              :text="['emails', 'social_media']"
              :group="[
              {'items':1, 'title':'Emails'},
              {'items':1, 'title':'Social Media'},
              {'items':1, 'title':'Other'},
              {'items':1, 'title':'Site Status'}
              ]"
              :select="{
              'state' : {0:'Fixing Bugs', 1:'Updating', 2:'Back Soon'}
              }"
              :icons="{
              'emails' : ['fa-info-circle', 'fa-envelope', 'fa-at', 'fa-envelope-o'],
              'social_media' : ['fa-facebook', 'fa-vk', 'fa-twitter', 'fa-instagram']
              }">
    </settings>
@endsection

@section('scripts')
    <script src="{{ asset('admin/plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
@endsection