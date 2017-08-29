@extends ('backend.layouts.master')

@section ('title', trans('menus.ticket_management') . ' | ' . trans('menus.edit_ticket'))

@section('page-header')
    <h1>
        {{ trans('menus.generaldiscount') }}
    </h1>
@endsection

@section('content')
    {!! Form::open(array('route' => array('admin.generaldiscount.apply'), 'method' => 'get', 'class' => 'form-horizontal'))  !!}
    <div class="form-group">
        <div class="col-lg-2">
            {!! Form::label('date_begin',  trans('strings.date_begin')) !!}
        </div>
        <div class="col-lg-10">
            {!! Form::text('date_begin', '', ['class' => 'datemask']) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <div class="col-lg-2">
            {!! Form::label('date_end',  trans('strings.date_end')) !!}
        </div>
        <div class="col-lg-10">
            {!! Form::text('date_end', '', ['class' => 'datemask']) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <div class="col-lg-2">
            {!! Form::label('percentage',  trans('strings.percentage')) !!}
        </div>
        <div class="col-lg-10">
            {!! Form::text('percentage', '') !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <div class="col-lg-2">
        {!! Form::label('sections', trans('strings.section'), ['class' => 'col-lg-2 control-label']) !!}
        </div>
        <div class="col-lg-10">
            {!! Form::select("sections[]", [''=>''] + $sections->lists("name","id")->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_subsections') ])  !!}

        </div>
    </div>


    <div class="form-group">
    {!! Form::submit( trans('strings.apply'), ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
    <br/>
@stop