@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        {{ trans('menus.userstudent_management') }}
        <small>{{ trans('menus.orders') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.access.users.index', trans('menus.orders')) !!}</li>
@stop

@section('content')
    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.userrepresentatives.edit', $userrepresentative->id)}}" class="btn btn-primary btn-xs">{{ trans('menus.edit_userrepresentatives') }}</a>
        <a href="{{route('admin.representativecommissions.index')}}?f_RepresentativeCommissionController_id={{$userrepresentative->id}}" class="btn btn-primary btn-xs">{{ trans('menus.representativecommissions') }}</a>
        <a href="{{route('admin.userrepresentatives.coupons', $userrepresentative->id)}}" class="btn btn-primary btn-xs">{{ trans('menus.coupons') }}</a>
    </div>
    <br/>
    <br/>
    <div class="pull-left" style="margin-bottom:10px">
        <a href="{{route('admin.userrepresentatives.addcoupons', $userrepresentative->id)}}" class="btn btn-primary btn-xs">{{ trans('menus.add_userrepresentatives_coupon') }}</a>
    </div>
    <br/>
    <br/>

    @if (sizeof($coupons) > 0 )

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
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    <div class="clearfix"></div>
@stop