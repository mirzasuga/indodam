@extends('layouts.app')

@section('title')
@yield('subtitle', __('user.detail')) - {{ $user->name }}
@endsection

@section('content')
<h3 class="page-header">
    <div class="pull-right">
        @yield('user-actions')
        @can('manage-users')
            {{ link_to_route('users.index', __('user.back_to_index'), [], ['class' => 'btn btn-default']) }}
        @endcan
    </div>
    {{ $user->name }} <small>{{ $user->wallet }} DAM</small>
</h3>

<div class="row">
    <div class="col-md-8 col-md-push-4">
        @include('users.partials.nav-tabs')
        @yield('content-user')
    </div>
    <div class="col-md-4 col-md-pull-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('user.profile') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><td class="col-xs-4">{{ __('user.name') }}</td><td>{{ $user->name }}</td></tr>
                    <tr><td>{{ __('user.username') }}</td><td>{{ $user->username }}</td></tr>
                    <tr><td>{{ __('user.username_edinar') }}</td><td>{{ $user->username_edinar }}</td></tr>
                    @can ('see-detail', $user)
                    <tr><td>{{ __('user.package') }}</td><td>{{ optional($user->package)->name }}</td></tr>
                    <tr><td>{{ __('user.email') }}</td><td>{{ $user->email }}</td></tr>
                    @endcan
                    <tr><td>{{ __('user.phone') }}</td><td>{{ $user->phone }}</td></tr>
                    <tr><td>{{ __('user.wallet') }}</td><td class="text-right">{{ $user->wallet }}</td></tr>
                    <tr><td>{{ __('user.wallet_edinar') }}</td><td class="text-right">{{ $user->wallet_edinar }}</td></tr>
                    <tr><td>{{ __('user.city') }}</td><td>{{ $user->city }}</td></tr>
                    @can ('see-detail', $user)
                    <tr><td>{{ __('user.address') }}</td><td>{{ $user->address }}</td></tr>
                    <tr><td>{{ __('user.indodax_email') }}</td><td>{{ $user->indodax_email }}</td></tr>
                    <tr><td>{{ __('user.sponsor') }}</td><td>{{ optional($user->sponsor)->name }}</td></tr>
                    <tr><td>{{ __('user.referral_code') }}</td><td>{{ $user->referral_code }}</td></tr>
                    <tr><td>{{ __('user.data_brand_key') }}</td><td>{{ $user->data_brand_key }}</td></tr>
                    @endcan
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
