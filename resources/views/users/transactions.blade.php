@extends('layouts.user')

@section('subtitle', __('user.transactions'))

@section('user-actions')
@can ('transfer-wallet', $user)
    {{ link_to_route('profile.transactions.index', __('transaction.transfer'), [$user, 'action' => 'transfer'], ['class' => 'btn btn-default', 'id' => 'transfer-'.$user->id]) }}
@endcan

@can ('update', $user)
    <div class="btn-group" role="group" aria-label="__('transaction.transaction')">
        {{ link_to_route('profile.transactions.index', __('transaction.deposit'), [$user, 'action' => 'deposit-wallet'], ['class' => 'btn btn-default', 'id' => 'deposit-wallet']) }}
        {{ link_to_route('profile.transactions.index', __('transaction.withdraw'), [$user, 'action' => 'withdraw-wallet'], ['class' => 'btn btn-default', 'id' => 'withdraw-wallet']) }}
    </div>
    {{ link_to_route('profile.transactions.index', __('user.edit_wallet'), [$user, 'action' => 'edit-wallet'], ['class' => 'btn btn-info', 'id' => 'edit-wallet-'.$user->id]) }}
@endcan
@endsection

@section('content-user')
<div class="panel panel-default table-responsive">
    <div class="panel-heading"><h3 class="panel-title">{{ __('transaction.incomes') }}</h3></div>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th class=" text-center" title="{{ __('transaction.id') }}">{{ __('app.id') }}</th>
                <th class=" text-center">{{ __('app.date') }}</th>
                <th class=" text-center">{{ __('app.time') }}</th>
                <th class="">{{ __('transaction.sender') }}</th>
                <th class="">{{ __('transaction.type') }}</th>
                <th class=" text-right">{{ __('transaction.amount') }}</th>
                <th class="">{{ __('transaction.description') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomes as $income)
            <tr>
                <td class="text-center">{{ $income->id }}</td>
                <td class="text-center">{{ $income->created_at->format('Y-m-d') }}</td>
                <td class="text-center">{{ $income->created_at->format('H:i:s') }}</td>
                <td>{{ $income->sender->name }}</td>
                <td>{{ $income->type_label }}</td>
                <td class="text-right">{{ $income->amount }}</td>
                <td>{{ $income->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="panel panel-default table-responsive">
    <div class="panel-heading"><h3 class="panel-title">{{ __('transaction.outcomes') }}</h3></div>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th class=" text-center" title="{{ __('transaction.id') }}">{{ __('app.id') }}</th>
                <th class=" text-center">{{ __('app.date') }}</th>
                <th class=" text-center">{{ __('app.time') }}</th>
                <th class="">{{ __('transaction.receiver') }}</th>
                <th class="">{{ __('transaction.type') }}</th>
                <th class=" text-right">{{ __('transaction.amount') }}</th>
                <th class="">{{ __('transaction.description') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($outcomes as $outcome)
            <tr>
                <td class="text-center">{{ $outcome->id }}</td>
                <td class="text-center">{{ $outcome->created_at->format('Y-m-d') }}</td>
                <td class="text-center">{{ $outcome->created_at->format('H:i:s') }}</td>
                <td>{{ $outcome->receiver->name }}</td>
                <td>{{ $outcome->type_label }}</td>
                <td class="text-right">{{ $outcome->amount }}</td>
                <td>{{ $outcome->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@can ('update', $user)
@if (request('action') == 'deposit-wallet')
    <div id="transactionEntryModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{ link_to_route('profile.transactions.index', '&times;', $user, ['class' => 'close']) }}
                    <h4 class="modal-title">{{ __('transaction.deposit_wallet') }}</h4>
                </div>
                {{ Form::open(['route' => ['profile.transactions.deposit', $user]]) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">{!! FormField::radios('type', $depositTypeList, ['required' => true, 'label' => __('transaction.type'), 'list_style' => 'unstyled']) !!}</div>
                        <div class="col-md-7">
                            {!! FormField::text('amount', ['required' => true, 'label' => __('transaction.amount'), 'placeholder' => 'Contoh: 99.99']) !!}
                            {!! FormField::textarea('description', ['required' => true, 'label' => __('transaction.description')]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label class="text-warning">
                                <input required="required" type="checkbox" name="double_check">
                                {!! __('transaction.double_check') !!}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::submit(__('transaction.deposit_wallet'), ['class' => 'btn btn-success']) }}
                    {{ link_to_route('profile.transactions.index', __('app.cancel'), $user, ['class' => 'btn btn-default']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endif
@if (request('action') == 'withdraw-wallet')
    <div id="transactionEntryModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{ link_to_route('profile.transactions.index', '&times;', $user, ['class' => 'close']) }}
                    <h4 class="modal-title">{{ __('transaction.withdraw_wallet') }}</h4>
                </div>
                {{ Form::open(['route' => ['profile.transactions.withdraw', $user]]) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">{!! FormField::radios('type', $withdrawTypeList, ['required' => true, 'label' => __('transaction.type'), 'list_style' => 'unstyled']) !!}</div>
                        <div class="col-md-7">
                            {!! FormField::text('amount', ['required' => true, 'label' => __('transaction.amount'), 'placeholder' => 'Contoh: 99.99']) !!}
                            {!! FormField::textarea('description', ['required' => true, 'label' => __('transaction.description')]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label class="text-warning">
                                <input required="required" type="checkbox" name="double_check">
                                {!! __('transaction.double_check') !!}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::submit(__('transaction.withdraw_wallet'), ['class' => 'btn btn-warning']) }}
                    {{ link_to_route('profile.transactions.index', __('app.cancel'), $user, ['class' => 'btn btn-default']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endif

@if (request('action') == 'edit-wallet')
    <div id="walletEditModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{ link_to_route('profile.transactions.index', '&times;', $user, ['class' => 'close']) }}
                    <h4 class="modal-title">{{ __('user.edit_wallet') }}</h4>
                </div>
                {{ Form::model($user, ['route' => ['profile.wallet-update', $user], 'method' => 'patch']) }}
                <div class="modal-body row">
                    <div class="col-md-6">{!! FormField::text('wallet_edinar', ['required' => true, 'label' => __('user.wallet_edinar')]) !!}</div>
                </div>
                <div class="modal-footer">
                    {{ Form::submit(__('user.wallet_update'), ['class' => 'btn btn-success']) }}
                    {{ link_to_route('profile.transactions.index', __('app.cancel'), $user, ['class' => 'btn btn-default']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endif

@endcan

@can ('transfer-wallet', $user)
    @includeWhen(request('action') == 'transfer', 'transactions.partials.transfer-form')
@endcan

@endsection

@push('scripts')
<script>
(function () {
    $('#walletEditModal,#transactionEntryModal').modal({
        show: true,
        backdrop: 'static',
    });
})();
</script>
@endpush
