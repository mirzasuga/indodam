@extends('layouts.user')

@section('subtitle', __('user.summary'))

@section('user-actions')
    @include('users.partials.user-actions')
@endsection

@section('content-user')
    @if($mining->started_at === '')
        @include('minings.partials.create')
    @else
        @include('minings.partials.stats')
    @endif
@endsection
