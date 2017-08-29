@extends ('backend.layouts.master')

@section ('title', trans('menus.ticket_management') . ' | ' . trans('menus.edit_ticket'))

@section('page-header')
    <h1>
        {{ trans('menus.processteacherstatements') }}
    </h1>
@endsection

@section('content')
    {!! Form::open(array('route' => array('admin.processteacherstatements.process'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
    <div class="form-group">
            <div class="col-lg-2">
                {!! Form::label('datebegin',  trans('strings.base_date_to_process')) !!}
            </div>
        <div class="col-lg-10">
            {!! Form::text('datebegin', '', ['class' => 'datemask']) !!}
            -
            {!! Form::text('dateend', '', ['class' => 'datemask']) !!}
        </div>
    </div><!--form control-->
    <div class="form-group">
        <div class="col-lg-10">
            {!! Form::submit( trans('strings.process'), ['class' => 'btn btn-primary']) !!}
        </div><!--form control-->
    </div><!--form control-->
    {!! Form::close() !!}
    <br/>
@stop