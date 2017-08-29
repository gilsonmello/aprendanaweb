@extends ('backend.layouts.master')

@section ('title', trans('menus.coupon_management') . ' | ' . trans('menus.import_coupon'))

@section('page-header')
    <h1>
        {{ trans('menus.coupon_management') }}
        <small>{{ trans('menus.import_coupon') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.coupons.index', trans('menus.coupons')) !!}</li>
    <li class="active">{!! link_to_route('admin.coupons.import', trans('menus.import_coupon')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.coupons.importfrompartner', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'get']) !!}

    <div class="pull-right">
        <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
    </div>
    <div class="clearfix"></div>

      {!! Form::close() !!}
@stop