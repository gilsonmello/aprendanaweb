@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        {{ trans('menus.create_enrollment_saapincourse') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.enrollments.indextest', trans('menus.enrollments_saapincourse')) !!}</li>
    <li class="active">{!! link_to_route('admin.enrollments.createtest', trans('menus.create_enrollment_saapincourse')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.enrollments.storesaapincourse', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('title' , trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="form-input col-md-4">
            {!! Form::select('courses[]', [''=>''] + $courses->lists('title', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.course') ])  !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('title' , trans('strings.exam'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="form-input col-md-4">
            {!! Form::select('exams[]', [''=>''] + $exams->lists('title', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.exam') ])  !!}
        </div>
    </div>


    <div class="form-group">
        {!! Form::label('date_begin', trans('validation.attributes.date_begin'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date_begin', null, ['class' => 'form-control datemask datepicker', 'placeholder' => trans('validation.attributes.date_begin')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('time_begin', trans('strings.time_begin'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('time_begin', null, ['class' => 'form-control', 'placeholder' => trans('strings.time_begin')]) !!}
        </div>
    </div>


    <div class="form-group">
        {!! Form::label('date_end', trans('validation.attributes.date_end'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date_end', null, ['class' => 'form-control datemask datepicker', 'placeholder' => trans('validation.attributes.date_end')]) !!}
        </div>
    </div><!--form control-->


        <div class="pull-left">
            <a href="{{route('admin.banners.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop