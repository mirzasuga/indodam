@extends('layouts.app')

@section('title', __('user.edit').' - '.$user->name)

@section('content')

<div class="row">
    <div class="col-md-12">
        @if (request('action') == 'delete' && $user)
        @can('delete', $user)
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">{{ __('user.delete') }} : {{ $user->username }} ({{ $user->role }})</h3></div>
                <div class="panel-body">{{ __('app.delete_confirm') }}</div>
                <div class="panel-footer">
                    {!! FormField::delete(
                        ['route' => ['users.destroy', $user]],
                        __('app.delete_confirm_button'),
                        ['class'=>'btn btn-danger'],
                        [
                            'user_id' => $user->id,
                            'page' => request('page'),
                            'q' => request('q'),
                        ]
                    ) !!}
                    {{ link_to_route('users.edit', __('app.cancel'), [$user], ['class' => 'btn btn-default']) }}
                </div>
            </div>
        @endcan
        @else
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('user.edit') }} : {{ $user->name }} ({{ $user->role }})</h3></div>
            {!! Form::model($user, ['route' => ['users.update', $user], 'method' => 'patch']) !!}
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">{!! FormField::textDisplay('sponsor', optional($user->sponsor)->name, ['label' => __('user.sponsor')]) !!}</div>
                    <div class="col-md-6">{!! FormField::textDisplay('package', optional($user->package)->name, ['label' => trans('user.package')]) !!}</div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        {!! FormField::text('name', ['label' => __('app.name'), 'required' => true]) !!}
                        {!! FormField::text('username', ['label' => trans('user.username'), 'required' => true]) !!}
                        {!! FormField::text('username_edinar', ['label' => trans('user.username_edinar')]) !!}
                        {!! FormField::password('password', ['info' => ['text' => __('user.password_form_note')]]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! FormField::email('email', ['label' => __('user.email'), 'required' => true]) !!}
                        {!! FormField::text('phone', ['label' => trans('user.phone'), 'required' => true]) !!}
                        {!! FormField::text('city', ['label' => __('user.city'), 'required' => true]) !!}
                        {!! FormField::textarea('address', ['label' => trans('user.address')]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! FormField::email('indodax_email', ['label' => __('user.indodax_email')]) !!}
                        {!! FormField::text('referral_code', ['label' => trans('user.referral_code')]) !!}
                        {!! FormField::textarea('data_brand_key', ['label' => trans('user.data_brand_key'), 'rows' => 6]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! FormField::text('cloud_link', ['label' => trans('user.cloud_link')]) !!}
                        <div class="row">
                            <div class="col-xs-6">{!! FormField::text('cloud_start_date', ['label' => trans('user.cloud_start_date'), 'class' => 'date-select']) !!}</div>
                            <div class="col-xs-6">{!! FormField::text('cloud_end_date', ['label' => trans('user.cloud_end_date'), 'class' => 'date-select']) !!}</div>
                        </div>
                        {!! FormField::textarea('notes', ['label' => trans('user.notes'), 'rows' => 6]) !!}
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('user.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('profile.show', __('app.cancel'), [$user], ['class' => 'btn btn-default']) }}
                @can('delete', $user)
                    {{ link_to_route('users.edit', __('app.delete'), [$user, 'action' => 'delete'], ['class' => 'btn btn-danger pull-right', 'id' => 'del-user-'.$user->id]) }}
                @endcan
            </div>
            {!! Form::close() !!}
        </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
{{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
@endsection

@push('scripts')
{{ Html::script(url('js/plugins/jquery.datetimepicker.js')) }}
<script>
    (function() {
        $('.date-select').datetimepicker({
            timepicker:false,
            format:'Y-m-d',
            closeOnDateSelect: true,
            scrollInput: false
        });
    })();
    $('#password').attr('autocomplete', 'new-password');
</script>
@endpush


@push('scripts')
<script>
</script>
@endpush
