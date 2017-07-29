@extends('admin.layouts.admin')

@section('title', 'Users')

@section('page_title', 'Users')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                @include ("admin.users.tables.{$table}")
            </div>
        </div>
    </div>
@endsection