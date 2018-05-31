@extends('layouts.user')

@section('subtitle', __('user.summary'))

@section('user-actions')
    @include('users.partials.user-actions')
@endsection

@section('content-user')

    @if(empty($mining->started_mining))
        @include('minings.partials.create')
    @else
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @include('minings.partials.stats')
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">
            @include('minings.partials.increase-power')
        </div>
    </div>
    @endif
    
@endsection
