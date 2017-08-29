@extends ('backend.layouts.master')

@section ('title', trans('menus.partnerorderpayment_management') . ' | ' . trans('menus.create_partnerorderpayment'))

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        {{ trans('menus.partnerorderpayment_management') }}
        <small>{{ trans('menus.create_partnerorderpayment') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.partnerorderpayments.index', trans('menus.partnerorderpayments')) !!}</li>
    <li class="active">{!! link_to_route('admin.partnerorderpayments.create', trans('menus.create_partnerorderpayment')) !!}</li>
@stop

@section('content')
    {!! Form::model($partnerorderpayment, ['route' => ['admin.partnerorderpayments.update', $partnerorderpayment->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('due_date', trans('strings.due_date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('due_date', ($partnerorderpayment->due_date != null ? format_datebr($partnerorderpayment->due_date ) : ''), ['class' => 'form-control datepicker', 'placeholder' => trans('strings.due_date')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('value', trans('strings.price'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('value',  number_format($partnerorderpayment->value , 2, ',', '.' ) , ['class' => 'form-control money', 'placeholder' => trans('strings.price')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('paid_date', trans('strings.paid_date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('paid_date', ($partnerorderpayment->paid_date != null ? format_datebr($partnerorderpayment->paid_date ) : ''), ['class' => 'form-control datepicker', 'placeholder' => trans('strings.paid_date')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('paid_value', trans('strings.paid_value'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('paid_value',  number_format($partnerorderpayment->paid_value , 2, ',', '.' ) , ['class' => 'form-control money', 'placeholder' => trans('strings.paid_value')]) !!}
        </div>
    </div><!--form control-->


    <div class="pull-left">
        <a href="{{route('admin.partnerorderpayments.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
    </div>


    <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop