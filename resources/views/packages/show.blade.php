@extends('layouts.app')

@section('title', trans('package.detail'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('package.detail') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><td>{{ trans('package.name') }}</td><td>{{ $package->name }}</td></tr>
                    <tr><td>{{ trans('package.price') }}</td><td>{{ formatRp($package->price) }}</td></tr>
                    <tr><td>{{ trans('package.wallet') }}</td><td>{{ $package->wallet }}</td></tr>
                    <tr><td>{{ trans('package.system_portion') }}</td><td>{{ $package->system_portion }}</td></tr>
                    <tr>
                        <td>{{ trans('package.sponsor_bonus_total') }}</td>
                        <td>
                            {{ $package->sponsor_bonus_total }}
                            {{ link_to_route('options.page-1', 'Atur Bonus Sponsor', [], ['class' => 'btn btn-default btn-xs pull-right', 'title' => __('option.sponsor_bonus_setting')]) }}
                        </td>
                    </tr>
                    <tr><td>{{ trans('package.description') }}</td><td>{{ $package->description }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                @can('update', $package)
                    {{ link_to_route('packages.edit', trans('package.edit'), [$package], ['class' => 'btn btn-warning', 'id' => 'edit-package-'.$package->id]) }}
                @endcan
                {{ link_to_route('packages.index', trans('package.back_to_index'), [], ['class' => 'btn btn-default']) }}
            </div>
        </div>
    </div>
</div>
@endsection
