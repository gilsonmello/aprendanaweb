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
    <li class="active">{!! link_to_route('admin.preenrollments.create', trans('menus.import_preenrollment')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.preenrollments.import', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('partner_id', trans('strings.partner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('partner_id', [''=>''] + $partners->lists("name","id")->all(), null, ['class' => 'form-control']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('importfile', trans('strings.importfile'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="importfile"/>
        </div><!-- /.col -->
    </div>


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