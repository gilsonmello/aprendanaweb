@extends ('backend.layouts.master')

@section ('title', trans('menus.preenrollment_management') . ' | ' . trans('menus.create_preenrollment'))

@section('page-header')
    <h1>
        {{ trans('menus.preenrollment_management') }}
        <small>{{ trans('menus.create_preenrollment') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.preenrollments.index', trans('menus.preenrollment')) !!}</li>
    <li class="active">{!! link_to_route('admin.preenrollments.create', trans('menus.create_preenrollment')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.preenrollments.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('partner_id', trans('strings.partner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('partner_id', $partners->lists("name","id"), null, ['class' => 'form-control']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('course_id', trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('course_id', $courses->lists("title","id"), null, ['class' => 'form-control']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('total_enrollments', trans('strings.total_enrollments'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('total_enrollments', null, ['class' => 'form-control', 'placeholder' => trans('strings.total_enrollments')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('date', trans('strings.date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date', null, ['class' => 'form-control datepicker', 'placeholder' => trans('strings.date')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('external_course_id', trans('crud.preenrollments.external_course_id'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('external_course_id', null, ['class' => 'form-control', 'placeholder' => trans('crud.preenrollments.external_course_id')]) !!}
        </div>

    </div><!--form control-->
    <div class="form-group">
        {!! Form::label('html_email', trans('crud.preenrollments.html_email'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="box-body" style="padding: 0px;">
                {!! Form::textarea('html_email', null, ['class' => 'form-control', 'placeholder' => trans('strings.html_email')]) !!}
            </div>
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('html_subscribe', trans('crud.preenrollments.html_subscribe'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="box-body" style="padding: 0px;">
                {!! Form::textarea('html_subscribe', null, ['class' => 'form-control', 'placeholder' => trans('strings.html_subscribe')]) !!}
            </div>
        </div>
    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.preenrollments.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop