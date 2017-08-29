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
        <a href="{{route('admin.preenrollments.importselectfile')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.import_preenrollment') }}
        </a>
        <a href="{{route('admin.preenrollments.studentgroups')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.email_preenrollment') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-name">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.preenrollments.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_PartnerController_partner_id',  trans('strings.partner'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::select('f_PartnerController_partner_id', [''=>''] + $partners->lists('name', 'id')->all(), $preenrollmentcontrollerpartnerid, ['class' => 'select2']) !!}
                </div>
            </div>
            <hr>
            <div class="row">
                {!! Form::label('f_PartnerController_studentname',  trans('strings.student'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-4">
                    {!! Form::text('f_PartnerController_name', $preenrollmentcontrollerstudentname, ['class' => 'form-control']  ) !!}
                </div>
                <div class="col-md-4">
                    Status&nbsp;&nbsp;
                    <label>{!! Form::radio('f_PartnerController_status', '2',($preenrollmentcontrollerstatus ===  '2' ? true : false)) !!} {!!trans('strings.all_male')!!}</label>&nbsp;
                    <label>{!! Form::radio('f_PartnerController_status', '1',($preenrollmentcontrollerstatus ===  '1' ? true : false)) !!} {!!trans('strings.confirmed')!!}</label>&nbsp;
                    <label>{!! Form::radio('f_PartnerController_status', '0',($preenrollmentcontrollerstatus ===  '0' ? true : false)) !!} {!!trans('strings.pending')!!}</label>
                </div>

                <div class="col-md-2">
                    <div >
                        <div class="sw-green create-permissions-switch">
                            <div class="onoffswitch">
                                <label class="control-label">{{ trans('validation.attributes.export_to_csv') }}</label>
                                <input type="checkbox" value="1" name="f_CourseController_export_to_csv" class="toggleBtn onoffswitch-checkbox" id="export_to_csv" >
                                <label for="export_to_csv" class="onoffswitch-label">
                                    <div class="onoffswitch-inner"></div>
                                    <div class="onoffswitch-switch"></div>
                                </label>
                            </div>
                        </div><!--green checkbox-->
                    </div>
                </div>
            </div>

        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="20%">{{ trans('strings.student') }}</th>
            <th width="10%">{{ trans('strings.partner') }}</th>
            <th width="30%">{{ trans('strings.course') }}</th>
            <th width="7%">{{ trans('crud.preenrollments.date_email') }}</th>
            <th width="7%">{{ trans('crud.preenrollments.date_deadline') }}</th>
            <th width="7%">{{ trans('crud.preenrollments.date_activation') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($preenrollments as $preenrollment)
            <tr>
                <td>{!! $preenrollment->student->name !!}</td>
                <td>{!! $preenrollment->partner->name !!}</td>
                <td>{!! $preenrollment->course->title !!}</td>
                <td>{!! format_datebr( $preenrollment->date_email ) !!}</td>
                <td>{!! format_datebr( $preenrollment->date_deadline ) !!}</td>
                <td>{!! format_datebr( $preenrollment->date_activation ) !!}</td>
                <td>{!! $preenrollment->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $preenrollments->total() !!} {{ trans('crud.preenrollments.total') }}
    </div>

    <div class="pull-right">
        {!! $preenrollments->render() !!}
    </div>



    <div class="clearfix"></div>
@stop