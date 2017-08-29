@extends ('backend.layouts.master')

@section ('title', trans('menus.coupons'))

@section('page-header')
    <h1>
        {{ trans('menus.coupons') }}
        <small>{{ trans('menus.all_coupons') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.coupons.index', trans('menus.coupons')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.coupons.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_coupon') }}
        </a>
        {{--<a href="{{route('admin.coupons.import')}}" class="btn btn-primary btn-xs">--}}
            {{--{{ trans('menus.import_coupon') }}--}}
        {{--</a>--}}
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.coupons.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_CouponController_name',  trans('strings.title'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_CouponController_name', $couponcontrollername, ['class' => 'form-control']  ) !!}
                </div>
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
            <th>{{ trans('crud.coupons.id') }}</th>
            <th>{{ trans('crud.coupons.name') }}</th>
            <th>{{ trans('crud.coupons.code') }}</th>
            <th>{{ trans('crud.coupons.start_date') }}</th>
            <th>{{ trans('crud.coupons.due_date') }}</th>
            <th class="text-right">{{ trans('crud.coupons.limit') }}</th>
            <th class="text-right">{{ trans('crud.coupons.used') }}</th>
            <th class="text-right">{{ trans('crud.coupons.percentage') }}</th>
            <th class="text-right">{{ trans('crud.coupons.value') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($coupons as $coupon)
            <tr>
                <td>{!! $coupon->id !!}</td>
                <td>{!! $coupon->name !!}</td>
                <td>{!! $coupon->code !!}</td>
                <td>{!! $coupon->start_date !!}</td>
                <td>{!! $coupon->due_date !!}</td>
                <td class="text-right">{!! number_format($coupon->limit, 0, ',', '.' )  !!}</td>
                <td class="text-right">{!! number_format($coupon->used, 0, ',', '.' )  !!}</td>
                <td class="text-right">{!! number_format($coupon->percentage, 2, ',', '.' )  !!}</td>
                <td class="text-right">{!! number_format($coupon->value, 2, ',', '.' )  !!}</td>
                <td>{!! $coupon->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $coupons->total() !!} {{ trans('crud.coupons.total') }}
    </div>

    <div class="pull-right">
        {!! $coupons->render() !!}
    </div>

    <div class="clearfix"></div>
@stop