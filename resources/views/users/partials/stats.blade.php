<div class="panel panel-default table-responsive hidden-xs">
    <table class="table table-condensed table-bordered">
        <tr>
            <td class="col-xs-2 text-center">{{ trans('user.wallet') }}</td>
            <td class="col-xs-2 text-center">{{ trans('user.wallet_edinar') }}</td>
            <td class="col-xs-2 text-center">{{ trans('app.status') }}</td>
            <td class="col-xs-2 text-center">{{ trans('user.role') }}</td>
        </tr>
        <tr>
            <td class="text-center lead" style="border-top: none;">{{ $user->wallet }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $user->wallet_edinar }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $user->status }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $user->role }}</td>
        </tr>
    </table>
</div>

<ul class="list-group visible-xs">
    <li class="list-group-item">{{ trans('user.wallet') }} <span class="pull-right">{{ $user->wallet }}</span></li>
    <li class="list-group-item">{{ trans('user.wallet_edinar') }} <span class="pull-right">{{ $user->wallet_edinar }}</span></li>
    <li class="list-group-item">{{ trans('app.status') }} <span class="pull-right">{{ $user->status }}</span></li>
    <li class="list-group-item">{{ trans('user.role') }} <span class="pull-right">{{ $user->role }}</span></li>
</ul>
@if (auth()->user()->can('see-detail', $user) && $user->notes)
<div class="well well-sm">
    <strong>{{ trans('user.notes') }}</strong><br>{!! nl2br($user->notes) !!}
</div>
@endif
