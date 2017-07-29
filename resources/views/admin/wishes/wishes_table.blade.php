@extends('admin.layouts.admin')

@section('title', 'Wishes')

@section('page_title', 'Wishes')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                @include ("admin.wishes.tables.{$table}")
            </div>
        </div>
    </div>
@endsection