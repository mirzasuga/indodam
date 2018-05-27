@extends('layouts.user')

@section('subtitle', __('user.summary'))

@section('user-actions')
    @include('users.partials.user-actions')
@endsection

@section('content-user')
    @include('users.partials.stats')

    <div class="row">
        <div class="col-md-6">
            @include('users.partials.sponsor-list')
        </div>
    </div>
@endsection
