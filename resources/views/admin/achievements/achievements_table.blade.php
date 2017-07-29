@extends('admin.layouts.admin')

@section('title', 'Achievements')

@section('page_title', 'Achievements')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                @include ("admin.achievements.tables.{$table}")
            </div>
        </div>
    </div>
@endsection