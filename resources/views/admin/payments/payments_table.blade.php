@extends('admin.layouts.admin')

@section('title', 'Payments')

@section('page_title', 'Payments')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                @include ("admin.payments.tables.{$table}")
            </div>
        </div>
    </div>
@endsection