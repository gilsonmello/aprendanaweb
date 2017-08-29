
@extends ('backend.layouts.master')

@section ('title', trans('menus.preenrollment_management') . ' | ' . trans('menus.edit_preenrollment'))

@section('page-header')
    <h1>
        {{ trans('menus.preenrollments') }}
        <small>{{ trans('menus.edit_preenrollment') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.preenrollments.index', trans('menus.preenrollments')) !!}</li>
    <li class="active">{!! link_to_route('admin.preenrollments.create', trans('menus.edit_preenrollment')) !!}</li>
@stop

@section('content')

    {!! Form::model($preenrollment, ['route' => ['admin.preenrollments.update', $preenrollment->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('partner_id', trans('strings.partner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('partner_id', $preenrollment->partner->name, ['class' => 'form-control','disabled']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('course_id', trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('course_id', $preenrollment->course->title, ['class' => 'form-control','disabled']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('total_enrollments', trans('strings.total_enrollments'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('total_enrollments', null, ['class' => 'form-control', 'placeholder' => trans('strings.total_enrollments'),'disabled']) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('date', trans('strings.date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date', format_datebr( $preenrollment->date), ['class' => 'form-control', 'placeholder' => trans('strings.date'),'disabled']) !!}
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
            <a href="{{route('admin.preenrollments.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop