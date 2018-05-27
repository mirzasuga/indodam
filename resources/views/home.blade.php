@extends('layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default table-responsive">
                <div class="panel-heading">{{ __('dashboard.dashboard') }}</div>
                <div class="panel-body">{{ __('auth.welcome', ['name' => $user->name]) }}</div>
                <table class="table table-condensed table-bordered hidden-xs">
                    <tr>
                        <td class="col-xs-2 text-center">{{ trans('user.name') }}</td>
                        <td class="col-xs-2 text-center">{{ trans('user.wallet') }}</td>
                        <td class="col-xs-2 text-center">{{ trans('user.wallet_edinar') }}</td>
                        <td class="col-xs-2 text-center">{{ trans('user.cloud_end_date') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center lead" style="border-top: none;">{{ $user->name }}</td>
                        <td class="text-center lead" style="border-top: none;">{{ $user->wallet }}</td>
                        <td class="text-center lead" style="border-top: none;">{{ $user->wallet_edinar }}</td>
                        <td class="text-center lead" style="border-top: none;">{{ $user->cloud_end_date ?: '-' }}</td>
                    </tr>
                </table>
            </div>

            <ul class="list-group visible-xs">
                <li class="list-group-item">{{ trans('user.name') }} <span class="pull-right">{{ $user->name }}</span></li>
                <li class="list-group-item">{{ trans('user.wallet') }} <span class="pull-right">{{ $user->wallet }}</span></li>
                <li class="list-group-item">{{ trans('user.wallet_edinar') }} <span class="pull-right">{{ $user->wallet_edinar }}</span></li>
                <li class="list-group-item">{{ trans('user.cloud_end_date') }} <span class="pull-right">{{ $user->cloud_end_date }}</span></li>
            </ul>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">{{ __('transaction.incomes') }}</h3></div>
                        <table class="table table-condensed">
                            <tbody>
                                @foreach ($user->incomes()->latest()->take(5)->get() as $income)
                                <tr>
                                    <td class="text-center">{{ $income->created_at->format('d M') }}</td>
                                    <td class="text-middle">{{ $income->type_label }}</td>
                                    <td class="text-middle text-right">{{ $income->amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">{{ __('transaction.outcomes') }}</h3></div>
                        <table class="table table-condensed">
                            <tbody>
                                @foreach ($user->outcomes()->latest()->take(5)->get() as $outcome)
                                <tr>
                                    <td class="text-center">{{ $outcome->created_at->format('M-d') }}</td>
                                    <td class="text-middle">{{ $outcome->type_label }}</td>
                                    <td class="text-middle text-right">{{ $outcome->amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
