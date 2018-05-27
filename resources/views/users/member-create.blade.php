@extends('layouts.app')

@section('title', trans('member.create'))

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('member.create') }}</h3></div>
            {!! Form::open(['route' => ['profile.members.store', $user]]) !!}
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-7">{!! FormField::textDisplay('sponsor', $user->name, ['label' => trans('user.sponsor')]) !!}</div>
                    <div class="col-md-5">
                        {!! FormField::text(
                            'sponsor_wallet',
                            [
                                'value' => $user->wallet,
                                'label' => trans('user.sponsor_wallet'),
                                'class' => 'text-right',
                                'disabled' => true,
                                'addon' => ['after' => 'DAM']
                            ]
                        ) !!}
                    </div>
                </div>

                <div class="table-responsive">
                <table class="table table-condensed table-hover package-selection">
                    <thead>
                        <tr>
                            <th class="col-xs-1 text-center">{{ trans('app.pick') }}</th>
                            <th class="col-xs-3">{{ trans('package.package') }}</th>
                            <th class="col-xs-2 text-right">{{ trans('package.wallet') }}</th>
                            <th class="col-xs-3 text-right">{{ trans('package.price') }}</th>
                            <th class="col-xs-3 text-right">{{ trans('package.wallet_threshold') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages = App\Package::all() as $package)
                        <tr>
                            <td class="text-center">
                                @if ($user->can('add-member', $package))
                                    {{ Form::radio(
                                        'package_id',
                                        $package->id,
                                        null,
                                        [
                                            'id' => 'package_id_'.$package->id,
                                            'title' => 'Pilih paket '.$package->name
                                        ]
                                    ) }}
                                @else
                                    <span
                                        class="close"
                                        style="float: none;"
                                        title="Tidak dapat menambah member pada paket {{ $package->name }}"
                                    >
                                        &times;
                                    </span>
                                @endif
                            </td>
                            <td>
                                <label for="{{ 'package_id_'.$package->id }}">{{ $package->name }}</label>
                            </td>
                            <td class="text-right">
                                <label for="{{ 'package_id_'.$package->id }}">{{ $package->wallet }}</label>
                            </td>
                            <td class="text-right">
                                <label for="{{ 'package_id_'.$package->id }}">{{ formatRp($package->price) }}</label>
                            </td>
                            <td class="text-right">
                                <label for="{{ 'package_id_'.$package->id }}">{{ $package->wallet_threshold }}</label>
                            </td>
                        </tr>
                        @endforeach
                        @if ($errors->has('package_id'))
                            <tr class="bg-danger text-center">
                                <td colspan="5" class="text-danger">Pilih salah satu paket.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </div>
                @if ($user->can('add-member', $packages->sortBy('wallet_threshold')->first()))
                <div class="row">
                    <div class="col-md-6">{!! FormField::text('name', ['label' => trans('app.name'), 'required' => true]) !!}</div>
                    <div class="col-md-6">{!! FormField::text('username', ['label' => trans('user.username'), 'required' => true]) !!}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">{!! FormField::text('phone', ['label' => trans('user.phone'), 'required' => true, 'type' => 'number']) !!}</div>
                    <div class="col-md-4">{!! FormField::email('email', ['label' => trans('user.email'), 'required' => true]) !!}</div>
                    <div class="col-md-4">{!! FormField::password('password', ['required' => true]) !!}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">{!! FormField::text('city', ['label' => trans('user.city'), 'required' => true]) !!}</div>
                </div>
                {!! FormField::textarea('address', ['label' => trans('user.address')]) !!}
                @else
                    <p class="text-danger">
                        Maaf wallet tidak cukup untuk menambah member.
                    </p>
                @endif
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('member.create'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('profile.members.index', trans('app.cancel'), [$user], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section ('styles')
<style>
.package-selection label { font-weight: normal; margin-bottom: 0 }
</style>
@endsection

@push('scripts')
<script>
    $('#password').attr('autocomplete', 'new-password');
</script>
@endpush
