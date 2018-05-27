@extends('layouts.app')

@section('title', trans('user.list'))

@section('content')

<h2 class="page-header visible-xs">
    {{ trans('user.list') }}
    <small style="font-size: 60%">
        {{ trans('app.total') }} : {{ $users->total() }}
        <p style="margin-top: 12px">Total Wallet : {{ $walletTotal }} DAM</p>
        <p>Total Edinar : {{ $edinarTotal }}</p>
    </small>
</h2>

<div class="well well-sm">
    {{ Form::open(['method' => 'get', 'class' => 'form-inline pull-right']) }}
    {!! FormField::text('q', ['value' => request('q'), 'label' => trans('user.search'), 'placeholder' => trans('user.search_placeholder'), 'style' => 'width:250px']) !!}
    {{ Form::submit(trans('user.search'), ['class' => 'btn btn-info']) }}
    {{ link_to_route('users.index', trans('app.reset'), [], ['class' => 'btn btn-default']) }}
    {{ Form::close() }}
    <div style="font-size: 24px;" class="hidden-xs">
        {{ trans('user.list') }}
        <small style="font-size: 60%">
            {{ trans('app.total') }} : {{ $users->total() }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Wallet : {{ $walletTotal }} DAM
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Edinar : {{ $edinarTotal }}
        </small>
    </div>
    <div class="clearfix"></div>
</div>

<div class="panel panel-default table-responsive">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th class="text-center">{{ trans('app.table_no') }}</th>
                <th>{{ trans('app.name') }}</th>
                <th>{{ trans('user.username') }}</th>
                <th class="text-right">{{ trans('user.wallet') }}</th>
                <th class="text-right">{{ trans('user.wallet_edinar') }}</th>
                <th>{{ trans('user.email') }}</th>
                <th class="text-center">{{ trans('user.package') }}</th>
                <th class="text-center">{{ trans('user.cloud_end_date') }}</th>
                <th class="text-center">{{ trans('user.status') }}</th>
                <th class="text-center">{{ trans('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $key => $user)
            <tr>
                <td class="text-center">{{ $users->firstItem() + $key }}</td>
                <td>{{ $user->nameLink() }}</td>
                <td>{{ $user->username }}</td>
                <td class="text-right">{{ $user->wallet }}</td>
                <td class="text-right">{{ $user->wallet_edinar }}</td>
                <td>{{ $user->email }}</td>
                <td class="text-center">{{ optional($user->package)->name }}</td>
                <td class="text-center">{{ $user->cloud_end_date }}</td>
                <td class="text-center">{{ $user->status }}</td>
                <td class="text-center">{{ link_to_route('profile.show', __('app.show'), [$user], ['class' => 'btn btn-default btn-xs']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{!! $users->appends(Request::except('page'))->render() !!}
@endsection

@section('styles')
<style>
@media only screen and (max-width: 768px) {
    .form-inline.pull-right {
        float: none!important;
    }
}
</style>
@endsection
