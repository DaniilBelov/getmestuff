@extends('admin.layouts.admin')

@section('title', 'Tickets')

@section('page_title', 'Tickets')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                @include ("admin.tickets.tables.{$table}")
            </div>
        </div>
    </div>
@endsection