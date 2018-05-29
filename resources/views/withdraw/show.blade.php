@extends('layouts.user')

@section('subtitle', __('user.summary'))

@section('user-actions')
    @include('users.partials.user-actions')
@endsection

@section('content-user')
    @include('withdraw.partials.form')
    @include('withdraw.partials.list')
@endsection
