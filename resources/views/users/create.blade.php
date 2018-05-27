@inject('roles', 'App\Role')
@extends('layouts.app')

@section('title', trans('user.create'))

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('user.create') }}</h3></div>
            {!! Form::open(['route' => 'users.store']) !!}
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-7">
                        {!! FormField::text('name', ['label' => trans('app.name'), 'required' => true]) !!}
                        {!! FormField::text('username', ['label' => trans('user.username'), 'required' => true]) !!}
                        {!! FormField::email('email', ['label' => trans('user.email'), 'required' => true]) !!}
                        {!! FormField::text('city', ['label' => trans('user.city'), 'required' => true]) !!}
                        {!! FormField::password('password', ['info' => ['text' => trans('user.default_password_note', ['password' => 'secret'])]]) !!}
                    </div>
                    <div class="col-md-5">
                        {!! FormField::radios('role_id', $roles->toArray(), ['required' => true, 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('user.create'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('users.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#password').attr('autocomplete', 'new-password');
</script>
@endpush
