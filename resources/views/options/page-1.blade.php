@extends('layouts.app')

@section('title', __('option.list'))

@section('content')
<h3 class="page-header">{{ __('option.option') }} {{ __('option.sponsor_bonus') }}</h3>
{{ Form::open(['route' => 'options.save-1', 'method' => 'patch']) }}
@php
    $packages = App\Package::all();
    $values = json_decode(Option::get('sponsor_bonus'), true);
@endphp
<div class="row">
    @foreach($packages as $key => $package)
    <div class="col-md-3">
        <legend class="page-header">{{ __('package.package') }} {{ $package->name }}</legend>
        <table class="table-condensed">
            <tbody>
                @foreach(range(1, config('indodam.sponsor_level_count')) as $level)
                <tr>
                    <td class="col-xs-4" style="vertical-align: top">{{ __('option.level') }} {{ $level }}</td>
                    <td class="col-xs-5">
                        {!! FormField::text('sponsor_bonus['.$package->id.']['.$level.']', [
                            'type'  => 'number',
                            'label' => false,
                            'min'   => 0,
                            'value' => isset($values[$package->id]) ? $values[$package->id][$level] : 0
                        ]) !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
</div>
{{ Form::submit(__('option.update'), ['class' => 'btn btn-warning']) }}
{{ link_to_route('packages.index', __('package.back_to_index'), [], ['class' => 'btn btn-default']) }}
{{ Form::close() }}
@endsection
