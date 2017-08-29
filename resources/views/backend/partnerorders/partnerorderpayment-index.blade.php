@extends ('backend.layouts.master')

@section ('title', trans('menus.partnerorderpayments'))



@section('page-header')
    <h1>
        {{ trans('menus.partnerorderpayments') }}
        <small>{{ trans('menus.all_partnerorderpayments') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.partnerorderpayments.index', trans('menus.partnerorderpayments')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.partnerorderpayments.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_partnerorderpayment') }}
        </a>
        <a href="{{route('admin.partnerorders.edit', $partnerorder )}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="15%">{{ trans('strings.due_date') }}</th>
            <th width="15%" class="text-right">{{ trans('strings.value') }}</th>
            <th width="15%">{{ trans('strings.paid_date') }}</th>
            <th width="15%" class="text-right">{{ trans('strings.paid_value') }}</th>
            <th width="15%">{{ trans('strings.processed') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($partnerorderpayments as $partnerorderpayment)
            <tr>
                <td>{!! $partnerorderpayment->due_date != null ? format_datebr($partnerorderpayment->due_date ) : '' !!}</td>
                <td class="text-right"> {!! number_format($partnerorderpayment->value , 2, ',', '.' ) !!}</td>
                <td>{!! $partnerorderpayment->paid_date != null ? format_datebr($partnerorderpayment->paid_date ) : '' !!}</td>
                <td class="text-right"> {!! number_format($partnerorderpayment->paid_value , 2, ',', '.' ) !!}</td>
                <td class="bold {{ ($partnerorderpayment->processed == 1 ? "green" :  "red" ) }}">
                    @if ($partnerorderpayment->processed === 1)
                        Sim
                    @else
                        Não
                    @endif

                </td>
                <td>{!! $partnerorderpayment->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $partnerorderpayments->total() !!} {{ trans('crud.partnerorderpayments.total') }}
    </div>

    <div class="pull-right">
        {!! $partnerorderpayments->render() !!}
    </div>

    <div class="clearfix"></div>
@stop