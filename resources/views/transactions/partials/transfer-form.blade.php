<div id="walletEditModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{ link_to_route('profile.transactions.index', '&times;', $user, ['class' => 'close']) }}
                <h4 class="modal-title">{{ __('transaction.transfer') }}</h4>
            </div>
            {{ Form::open(['method' => 'get']) }}
            {{ Form::hidden('action', 'transfer') }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">{!! FormField::textDisplay('sender_username', $user->username, ['label' => __('transaction.sender_username')]) !!}</div>
                    <div class="col-md-7">
                        <label for="receiver_username">{{ __('transaction.receiver_username') }}</label>
                        <div class="input-group">
                            {{ Form::text('receiver_username', null, ['required' => true, 'class' => 'form-control', 'id' => 'receiver_username', 'placeholder' => __('user.username')]) }}
                            <span class="input-group-btn">
                                {{ Form::submit(__('transaction.select_receiver'), ['class' => 'btn btn-info']) }}
                            </span>
                        </div><!-- /input-group -->
                    </div>
                </div>
            </div>
            {{ Form::close() }}
            @if ($receiver)
                @if ($user->can('transfer-to', $receiver))
                    {{ Form::open(['route' => ['profile.transactions.transfer', $user, $receiver], 'id' => 'transfer-wallet-form']) }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">{!! FormField::textDisplay('sender', $user->name, ['label' => __('transaction.sender')]) !!}</div>
                            <div class="col-md-6">{!! FormField::textDisplay('receiver', $receiver->name, ['label' => __('transaction.receiver')]) !!}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! FormField::text(
                                    'sponsor_wallet',
                                    [
                                        'value' => $user->wallet,
                                        'label' => trans('user.wallet'),
                                        'class' => 'text-right',
                                        'disabled' => true,
                                        'addon' => ['after' => 'DAM']
                                    ]
                                ) !!}
                            </div>
                            <div class="col-md-6">
                                {!! FormField::text(
                                    'amount',
                                    [
                                        'required' => true,
                                        'addon' => ['after' => 'DAM'],
                                        'label' => __('transaction.transfer_amount'),
                                        'placeholder' => 'Contoh: 99.99'
                                    ]
                                ) !!}
                            </div>
                        </div>
                        {!! FormField::textarea('description', ['required' => true, 'label' => __('transaction.description')]) !!}

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
                        {{ Form::submit(__('transaction.transfer'), ['class' => 'btn btn-success']) }}
                        {{ link_to_route('profile.transactions.index', __('app.cancel'), $user, ['class' => 'btn btn-default']) }}
                    </div>
                    {{ Form::close() }}
                @else
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            {!! __('transaction.not_in_network', ['sender' => $user->name, 'receiver' => $receiver->name]) !!}
                        </div>
                    </div>
                @endif
            @else
                <div class="modal-body">
                    <div class="alert alert-danger">
                        {{ __('user.not_found') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
