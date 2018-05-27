@extends('layouts.app')

@section('title', trans('package.edit'))

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @if (request('action') == 'delete' && $package)
        @can('delete', $package)
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">{{ trans('package.delete') }}</h3></div>
                <div class="panel-body">
                    <label class="control-label">{{ trans('package.name') }}</label>
                    <p>{{ $package->name }}</p>
                    <label class="control-label">{{ trans('package.price') }}</label>
                    <p>{{ $package->price }}</p>
                    <label class="control-label">{{ trans('package.wallet') }}</label>
                    <p>{{ $package->wallet }}</p>
                    <label class="control-label">{{ trans('package.system_portion') }}</label>
                    <p>{{ $package->system_portion }}</p>
                    <label class="control-label">{{ trans('package.description') }}</label>
                    <p>{{ $package->description }}</p>
                    {!! $errors->first('package_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
                <div class="panel-footer">
                    {!! FormField::delete(
                        ['route' => ['packages.destroy', $package]],
                        trans('app.delete_confirm_button'),
                        ['class'=>'btn btn-danger'],
                        [
                            'package_id' => $package->id,
                            'page' => request('page'),
                            'q' => request('q'),
                        ]
                    ) !!}
                    {{ link_to_route('packages.edit', trans('app.cancel'), [$package], ['class' => 'btn btn-default']) }}
                </div>
            </div>
        @endcan
        @else
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('package.edit') }}</h3></div>
            {!! Form::model($package, ['route' => ['packages.update', $package],'method' => 'patch']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => trans('package.name')]) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! FormField::price('price', [
                            'required' => true, 'label' => trans('package.price'),
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::text('wallet', [
                            'required' => true, 'type' => 'number', 'label' => trans('package.wallet'),
                            'addon' => ['after' => 'DAM'], 'class' => 'text-right', 'min' => 0
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::text('system_portion', [
                            'required' => true, 'type' => 'number', 'label' => trans('package.system_portion'),
                            'addon' => ['after' => 'DAM'], 'class' => 'text-right', 'min' => 0
                        ]) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => trans('package.description')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('package.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('packages.show', trans('app.cancel'), [$package], ['class' => 'btn btn-default']) }}
                @can('delete', $package)
                    {{ link_to_route('packages.edit', trans('app.delete'), [$package, 'action' => 'delete'], ['class' => 'btn btn-danger pull-right', 'id' => 'del-package-'.$package->id]) }}
                @endcan
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif
@endsection
