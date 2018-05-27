@extends('layouts.app')

@section('title', trans('package.create'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('package.create') }}</h3></div>
            {!! Form::open(['route' => 'packages.store']) !!}
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
                {!! Form::submit(trans('package.create'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('packages.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
