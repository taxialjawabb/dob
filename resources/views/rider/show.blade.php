
@extends('index')
@section('title','الركــاب')
@section('content')
{!! $dataTable->table( ['class' => 'table-responsive table table-striped table-hover table-bordered']) !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection