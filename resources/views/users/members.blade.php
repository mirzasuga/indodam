@extends('layouts.user')

@section('subtitle', __('user.members'))

@section('user-actions')
    @can('add-member', $user)
        {{ link_to_route(
            'profile.members.create', __('member.create'), [$user],
            ['class' => 'btn btn-success', 'id' => 'add-member-'.$user->id
        ]) }}
    @endcan
@endsection

@section('content-user')
<div class="panel panel-default table-responsive">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th class="text-center">{{ trans('app.table_no') }}</th>
                <th>{{ trans('app.name') }}</th>
                <th>{{ trans('user.username') }}</th>
                <th>{{ trans('user.username_edinar') }}</th>
                <th>{{ trans('user.phone') }}</th>
                <th class="text-right">{{ trans('user.wallet') }}</th>
                <th class="text-right">{{ trans('user.wallet_edinar') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $key => $member)
            <tr>
                <td class="text-center">{{ 1 + $key }}</td>
                <td>{{ $member->nameLink() }}</td>
                <td>{{ $member->username }}</td>
                <td>{{ $member->username_edinar }}</td>
                <td>{{ $member->phone }}</td>
                <td class="text-right">{{ $member->wallet }}</td>
                <td class="text-right">{{ $member->wallet_edinar }}</td>
            </tr>
            @empty
            <tr><td colspan="7">{{ __('user.no_members') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
