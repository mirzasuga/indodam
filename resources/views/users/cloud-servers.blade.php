@extends('layouts.user')

@section('subtitle', __('user.cloud_servers'))

@section('content-user')
<div class="panel panel-default table-responsive hidden-xs">
    <table class="table table-condensed table-bordered">
        <tr>
            <td class="col-xs-2 text-center">{{ trans('user.cloud_link') }}</td>
            <td class="col-xs-2 text-center">{{ trans('user.cloud_start_date') }}</td>
            <td class="col-xs-2 text-center">{{ trans('user.cloud_end_date') }}</td>
        </tr>
        <tr>
            <td class="text-center lead" style="border-top: none;">{{ $user->cloud_link ?: '-' }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $user->cloud_start_date ?: '-' }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $user->cloud_end_date ?: '-' }}</td>
        </tr>
    </table>
</div>

<ul class="list-group visible-xs">
    <li class="list-group-item">{{ trans('user.cloud_link') }} <span class="pull-right">{{ $user->cloud_link ?: '-' }}</span></li>
    <li class="list-group-item">{{ trans('user.cloud_start_date') }} <span class="pull-right">{{ $user->cloud_start_date ?: '-' }}</span></li>
    <li class="list-group-item">{{ trans('user.cloud_end_date') }} <span class="pull-right">{{ $user->cloud_end_date ?: '-' }}</span></li>
</ul>
@endsection
