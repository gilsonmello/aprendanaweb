@extends ('backend.layouts.master')

@section ('name', trans('menus.preenrollments'))



@section('page-header')
    <h1>
        {{ trans('menus.preenrollments') }}
        <small>{{ trans('menus.all_preenrollments') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.preenrollments.index', trans('menus.preenrollments')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.preenrollments.studentgroups')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-name">Enviar e-mails - {{ $studentgroup->partner->name }} - {{ $studentgroup->name }}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.preenrollments.sendemail'), 'class' => 'form-horizontal', 'method' => 'post'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_PreenrollmentController_studentgroup_id', $studentgroup->id  ) !!}
                <div class="col-md-10">
                    {!! Form::checkbox('f_PreenrollmentController_reset_date', '1', false) !!} {{ trans('menus.reset_date_preenrollment') }}
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.send'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="20%">{{ trans('strings.student') }}</th>
            <th width="30%">{{ trans('strings.course') }}</th>
            <th width="7%">{{ trans('crud.preenrollments.date_email') }}</th>
            <th width="7%">{{ trans('crud.preenrollments.date_deadline') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($preenrollments as $preenrollment)
            <tr>
                <td>{!! $preenrollment->student->name !!}</td>
                <td>{!! $preenrollment->course->title !!}</td>
                <td>{!! format_datebr( $preenrollment->date_email ) !!}</td>
                <td>{!! format_datebr( $preenrollment->date_deadline ) !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! count($preenrollments) !!} {{ trans('crud.preenrollments.total') }}
    </div>

    <div class="clearfix"></div>
@stop