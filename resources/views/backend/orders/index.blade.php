@extends ('backend.layouts.master')

@section ('title', trans('menus.orders'))



@section('page-header')
    <h1>
        {{ trans('menus.orders') }}
        <small>{{ trans('menus.all_orders') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.orders.index', trans('menus.orders')) !!}</li>
@stop

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Filtro</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    {!! Form::open(array('route' => array('admin.orders.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
            <div class="box-body">
                <div class="row">
                    {!! Form::hidden('f_submit', '1'  ) !!}
                    <div class="col-md-1">
                        {!! Form::label('f_OrderController_id',  trans('crud.orders.id'), ['class' => 'col-md-1 control-label']) !!}
                    </div>
                    <div class="col-md-1">
                        {!! Form::text('f_OrderController_id', $ordercontrollerid, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-1">
                        {!! Form::label('f_OrderController_date_begin',  trans('strings.registration_date_begin'), ['class' => 'col-md-2 control-label']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('f_OrderController_date_begin', $ordercontrollerdatebegin, ['class' => 'datemask form-control', 'style' => 'width:80%; display:inline-block;margin-right:10px;']) !!}
                        <strong>
                            {{trans('strings.registration_date_end')}}
                        </strong>
                    </div>

                    <div class="col-md-2">

                        {!! Form::text('f_OrderController_date_end', $ordercontrollerdateend, ['class' => 'datemask form-control', 'style' => 'width:80%;'] ) !!}
                    </div>
                    @if (sizeof($orderstatus) != 0)
                        <div class="col-md-1">
                            {!! Form::label('f_OrderController_status_id', trans('strings.status'), ['class' => 'col-md-1']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('f_OrderController_status_id', array('' => trans('strings.all_male') ) + ($orderstatus->lists('name', 'id')->all()), $ordercontrollerstatusid, ['class' => 'select2']) !!}
                        </div>
                    @endif
                    <div class="col-md-2">
                        <div>
                            <div class="sw-green create-permissions-switch">
                                <div class="onoffswitch">
                                    <label class="control-label">{{ trans('validation.attributes.export_to_csv') }}</label>
                                    <input type="checkbox" value="1" name="f_OrderController_export_to_csv" class="toggleBtn onoffswitch-checkbox" id="export_to_csv" >
                                    <label for="export_to_csv" class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div><!--green checkbox-->
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    {!! Form::label('f_OrderController_without_enrollment', trans('strings.released_without_enrollment'), ['style' => 'padding-top: 0', 'class' => 'col-md-2 control-label']) !!}

                    <div class="col-md-1">
                        {!!  Form::checkbox('f_OrderController_without_enrollment', '1', $orderwithoutenrollment === '1' ? 'checked' : "")  !!} 
                    </div>
                    {!! Form::label('f_OrderController_only_paid', trans('strings.only_paid'), ['style' => 'padding-top: 0', 'class' => 'col-md-2 control-label']) !!}

                    <div class="col-md-1">
                        {!!  Form::checkbox('f_OrderController_only_paid', '1', $orderonlypaid === '1' ? 'checked' : "")  !!} 
                    </div>
                </div>

                <hr>
                <div class="row">
                    
                </div>

            </div>
            <div class="box-footer">
                {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}    
            </div>
        {!! Form::close() !!}
</div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="5%">{{ trans('crud.orders.id') }}</th>
            <th width="23%">{{ trans('crud.orders.student') }}</th>
            <th width="16%">{{ trans('crud.orders.status') }}</th>
            <th width="16%">{{ trans('crud.orders.coupon_code') }}</th>
            <th width="16%">{{ trans('crud.orders.date_registration') }}</th>
            <th width="16%">{{ trans('crud.orders.date_confirmation') }}</th>
            <th width="" class="text-right">{{ trans('crud.orders.price') }}</th>
            <th width="" class="text-right">{{ trans('crud.orders.discount_price') }}</th>
            <th width="12%">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{!! $order->id !!}</td>
                <td>{!! $order->student != null ? $order->student->name : '' !!}</td>
                <td class="bold {{ $order->status_id == 4 ? "green" :  ($order->status_id == 5 ? "red" : "blue" ) }}">
                    {!! $order->status != null ? $order->status->name : '' !!}
                </td>
                <td class="bold">
                    {!! $order->coupon['code'] != null ? $order->coupon['code'] : '' !!}
                </td>
                <td>{!! format_datetimebr($order->date_registration) . ' (' . diff_time( $order->date_registration ) . ')'!!}</td>
                <td>{!! $order->date_confirmation != null ? format_datetimebr($order->date_confirmation ). ' (' . diff_time( $order->date_confirmation ) . ')' : '' !!}</td>
                <td class="text-right"> {!! number_format($order->price , 2, ',', '.' ) !!}</td>
                <td class="text-right"> {!! number_format($order->discount_price , 2, ',', '.' ) !!}</td>
                <td>{!! $order->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $orders->total() !!} {{ trans('crud.orders.total') }}
    </div>

    <div class="pull-right">
        {!! $orders->render() !!}
    </div>

    <div class="clearfix"></div>
@stop