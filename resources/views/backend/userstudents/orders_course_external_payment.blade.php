@extends ('backend.layouts.master')

@section ('title', trans('menus.ticket_management') . ' | ' . trans('menus.edit_ticket'))

@section('page-header')
    <h1>
        {{ trans('strings.new_value') }}
    </h1>
@endsection

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.userstudents.orders', $ordercourse->order->student_id)}}" class="btn btn-primary btn-xs">{{ trans('menus.orders') }}</a>
    </div>
    <br/>
    <br/>

    <p>Esta operação irá alterar em definitivo o valor de um item de pedido para o valor informado.</p>
    <br/>

    {!! Form::open(array('route' => array('admin.userstudents.course_external_payment_run'), 'class' => 'form-horizontal', 'method' => 'post'))  !!}
    {!! Form::hidden('ordercourse_id', $ordercourse->id, ['class' => '']) !!}
    <div class="form-group">
        <div class="col-lg-2">
            {!! Form::label('new_value',  trans('strings.new_value')) !!}
        </div>
        <div class="col-lg-10">
            {!! Form::text('value', '', ['class' => 'form-control money']) !!}
        </div>
    </div><!--form control-->
    <div class="form-group">
        <div class="col-lg-2">
            {!! Form::label('document_external_payment',  trans('strings.external_payment_document')) !!}
        </div>
        <div class="col-lg-10">
            {!! Form::text('document_external_payment', '', ['class' => 'form-control']) !!}
        </div>
    </div><!--form control-->
    <div class="form-group">
        <div class="col-lg-2">
            {!! Form::label('justification_external_payment',  trans('strings.justification_external_payment')) !!}
        </div>
        <div class="col-lg-10">
            {!! Form::text('justification_external_payment', '', ['class' => 'form-control']) !!}
        </div>
    </div><!--form control-->
    <div class="form-group">
        <div class="col-lg-10">
            {!! Form::submit( trans('strings.save_button'), ['class' => 'btn btn-primary']) !!}
        </div><!--form control-->
    </div><!--form control-->
    {!! Form::close() !!}
    <br/>
@stop