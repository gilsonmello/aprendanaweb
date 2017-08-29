@extends ('backend.layouts.master')

@section ('title', trans('menus.order_management') . ' | ' . trans('menus.edit_order'))

@section('page-header')
<h1>
    {{ trans('menus.orders') }}
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li>{!! link_to_route('admin.orders.index', trans('menus.orders')) !!}</li>
@stop

@section('content')

{!! Form::model($order, ['route' => ['admin.orders.update', $order->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

<div class="form-group">
    {!! Form::label('id', trans('strings.id'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('id',  $order->id, ['class' => 'form-control bold', 'disabled' => 'disabled']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('status', trans('strings.status'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('status', $order->status != null ? $order->status->name : '', ['class' => 'form-control bold ' . ($order->status_id == 4 ? "green" :  ($order->status_id == 5 ? "red" : "blue")), 'disabled' => 'disabled']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('student', trans('strings.student'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('student', $order->student != null ? $order->student->name : "", ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('date_registration', trans('strings.date_registration'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('date_registration', format_datetimebr($order->date_registration) . ' (' . diff_time( $order->date_registration ) . ')', ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('date_confirmation', trans('strings.date_confirmation'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('date_confirmation', $order->date_confirmation == null ? '' : format_datetimebr( $order->date_confirmation) . ' (' . diff_time( $order->date_confirmation ) . ')', ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('date_cancel', trans('strings.date_cancel'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('date_cancel', $order->date_cancel == null ? '' : format_datetimebr( $order->date_cancel) . ' (' . diff_time( $order->date_cancel ) . ')', ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('coupon', trans('strings.coupon_name'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('coupon',  $order->coupon != null ? $order->coupon->name : '', ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>

</div><!--form control-->
@if(count($ordercoupon) > 0)
<div class="form-group">
    {!! Form::label('coupon', 'Justificativa do Cupom', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::textarea('coupon',  $ordercoupon->description != null ?  $ordercoupon->description  : '', ['class' => 'form-control', 'disabled' => 'disabled']) !!}        
    </div>
</div>
@endif
<div class="form-group">
    {!! Form::label('coupon', trans('strings.code'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('coupon',  $order->coupon != null ? $order->coupon->code : '', ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>
</div><!--form control-->


<div class="form-group">
    {!! Form::label('price', trans('strings.value'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('price',  number_format($order->price, 2, ',', '.' ), ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>
</div><!--form control-->


<div class="form-group">
    {!! Form::label('discount_price', trans('strings.discount_price'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('discount_price',  number_format($order->discount_price, 2, ',', '.' ), ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>
</div><!--form control-->

<br/>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>{{ trans('strings.item') }}</th>
            <th class="text-right">{{ trans('strings.value') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ordercourses as $ordercourse)
        <tr>
            <td>{!! $ordercourse->course != null ? $ordercourse->course->title : "SEM CURSO" !!}</td>
            <td class="text-right"> {!! number_format($ordercourse->discount_price , 2, ',', '.' ) !!}</td>
        </tr>
        @endforeach
        @foreach ($orderpackages as $orderpackage)
        <tr>
            <td>{!! $orderpackage->package != null ? $orderpackage->package->title : "SEM CURSO" !!}</td>
            <td class="text-right"> {!! number_format($orderpackage->discount_price , 2, ',', '.' ) !!}</td>
        </tr>
        @endforeach
        @foreach ($ordermodules as $ordermodule)
        <tr>
            <td>{!! $ordermodule->module != null ? $ordermodule->module->name : "SEM DISCIPLINA" !!}</td>
            <td class="text-right"> {!! number_format($ordermodule->discount_price , 2, ',', '.' ) !!}</td>
        </tr>
        @endforeach
        @foreach ($orderlessons as $orderlesson)
        <tr>
            <td>{!! $orderlesson->lesson != null ? $orderlesson->lesson->title : "SEM AULA" !!}</td>
            <td class="text-right"> {!! number_format($orderlesson->discount_price , 2, ',', '.' ) !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<br/>
<div class="pull-left">
    <a href="{{route('admin.orders.index', ['page' => Session::get('lastpage', '1')] )}}" class="btn btn-danger">{{ trans('strings.back') }}</a>
</div>
{{--
    @if ($order->is_finished != 1)
    <br/>
    {!! Form::close() !!}

    {!! Form::open(array('route' => array('admin.orders.message.store'), 'method' => 'post'))  !!}
    {!! Form::hidden('order_id', $order->id  ) !!}
    {!! Form::label('message',  trans('strings.new_message_order')) !!}
    <br/>
    {!! Form::textarea('message', null ) !!}
    <br/>
    {!! Form::submit( trans('strings.send'), ['class' => 'btn btn-primary btn-xs']) !!}
    {!! Form::close() !!}
    <br/>
    {!! Form::open(array('route' => array('admin.orders.finish'), 'method' => 'post', 'onsubmit' => 'return confirm("'. trans('crud.orders.finish') . '");'))  !!}
    {!! Form::hidden('order_id', $order->id  ) !!}
    {!! Form::submit( trans('strings.finish'), ['class' => 'btn btn-primary btn-xs']) !!}
    {!! Form::close() !!}
    @endif
--}}

@stop