@extends('layouts.app')

@section('title', __('package.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        @can('create', new App\Package)
            {{ link_to_route('options.page-1', __('option.sponsor_bonus_setting'), [], ['class' => 'btn btn-default']) }}
            {{ link_to_route('packages.create', __('package.create'), [], ['class' => 'btn btn-success']) }}
        @endcan
    </div>
    {{ __('package.list') }}
</h1>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('package.name') }}</th>
                        <th class="text-right">{{ __('package.price') }}</th>
                        <th class="text-right">{{ __('package.wallet') }}</th>
                        <th class="text-right">{{ __('package.system_portion') }}</th>
                        <th class="text-center">{{ __('package.sponsor_bonus_total') }}</th>
                        <th>{{ __('package.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $key => $package)
                    <tr>
                        <td class="text-center">{{ 1 + $key }}</td>
                        <td>{{ $package->nameLink() }}</td>
                        <td class="text-right">{{ formatRp($package->price) }}</td>
                        <td class="text-right">{{ $package->wallet }}</td>
                        <td class="text-right">{{ $package->system_portion }}</td>
                        <td class="text-center">{{ $package->sponsor_bonus_total }}</td>
                        <td>{{ $package->description }}</td>
                        <td class="text-center">
                            @can('view', $package)
                                {!! link_to_route(
                                    'packages.show',
                                    __('app.show'),
                                    [$package],
                                    ['class' => 'btn btn-default btn-xs', 'id' => 'show-package-' . $package->id]
                                ) !!}
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4">{{ __('package.empty') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
