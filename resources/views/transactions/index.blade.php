@extends('layouts.app')

@section('title', __('transaction.list'))

@section('content')

<h2 class="page-header">
    {{ trans('transaction.list') }}
    <small style="font-size: 60%">{{ trans('app.total') }} : {{ $transactions->total() }}</small>
</h2>

<div class="well well-sm">
    {!! Form::open(['method' => 'get', 'class' => 'form-inline']) !!}
    {!! FormField::text('query', ['label' => trans('app.search'), 'placeholder' => trans('transaction.id')]) !!}
    {!! FormField::text('start_date', ['label' => trans('app.from'), 'value' => $startDate]) !!}
    {!! FormField::text('end_date', ['label' => trans('app.to'), 'value' => $endDate]) !!}
    {!! FormField::select('type', App\TransactionType::all(), ['label' => false, 'placeholder' => 'Semua '.trans('transaction.transaction')]) !!}
    {!! FormField::select('sender_id', $users, ['label' => false, 'placeholder' => 'Semua '.trans('transaction.sender')]) !!}
    {!! FormField::select('receiver_id', $users, ['label' => false, 'placeholder' => 'Semua '.trans('transaction.receiver')]) !!}
    {!! Form::submit(trans('app.filter'), ['class' => 'btn btn-info']) !!}
    {!! link_to_route('transactions.index', trans('app.reset'), [], ['class' => 'btn btn-default']) !!}
    {!! Form::close() !!}
</div>

<div class="panel panel-default table-responsive">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th class=" text-center">{{ __('app.table_no') }}</th>
                <th class=" text-center">{{ __('transaction.id') }}</th>
                <th class=" text-center">{{ __('transaction.time') }}</th>
                <th class="">{{ __('transaction.sender') }}</th>
                <th class="">{{ __('transaction.receiver') }}</th>
                <th class="">{{ __('transaction.type') }}</th>
                <th class=" text-right">{{ __('transaction.amount') }}</th>
                <th class="">{{ __('transaction.description') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $key => $transaction)
            <tr>
                <td class="text-center">{{ $transactions->firstItem() + $key }}</td>
                <td class="text-center">{{ $transaction->id }}</td>
                <td class="text-center">{{ $transaction->created_at }}</td>
                <td>{{ $transaction->sender->nameLink() }}</td>
                <td>{{ $transaction->receiver->nameLink() }}</td>
                <td>{{ $transaction->type_label }}</td>
                <td class="text-right">{{ $transaction->amount }}</td>
                <td>{{ $transaction->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $transactions->appends(Request::except('page'))->links() }}
@endsection

@section('styles')
{!! Html::style(url('css/plugins/jquery.datetimepicker.css')) !!}
<style>
    #query, #start_date, #end_date {
        width: 100px
    }
    @media only screen and (max-width: 768px) {
        .form-inline.pull-right {
            float: none!important;
        }
        #query, #start_date, #end_date {
            width: 100%
        }
    }
</style>
@endsection

@push('scripts')
    {!! Html::script(url('js/plugins/jquery.datetimepicker.js')) !!}
    <script>
    (function() {
        $('#start_date,#end_date').datetimepicker({
            timepicker:false,
            format:'Y-m-d',
            closeOnDateSelect: true
        });
    })();
</script>
@endpush
