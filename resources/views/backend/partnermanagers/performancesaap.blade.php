@extends ('backend.layouts.master')

@section ('title', trans('menus.student_performance'))

@section('page-header')
    <h1>
        {{ trans('menus.student_performance') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.student_execution_saap') !!}</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.partnermanagers.perfomancesaap'), 'method' => 'get'))  !!}

        {!! Form::hidden('f_submit', '1'  ) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-md-1">
                    {!! Form::label('f_PartnerManagerController_course_id', trans('strings.courses')) !!}
                </div>
                <div class="col-md-7">
                    {!! Form::select('f_PartnerManagerController_course_id', ['' => ''] + $courses->lists('title', 'id')->all(), $partnermanagercontrollercourseid, ['class' => 'select2']) !!}
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-2">
                    {!! Form::label('f_PartnerManagerController_partner_id', trans('strings.partners')) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::select('f_PartnerManagerController_partner_id', ['' => ''] + $partnerusers->lists('partners_name', 'partners_id')->all(), $partnermanagercontrollerpartnerid, ['class' => 'select2']) !!}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2" style="width: 10%">
                    {!! Form::label('f_PartnerManagerController_date_begin',  trans('strings.period')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-2">
                    {!! Form::text('f_PartnerManagerController_date_begin', $studentreportcontrollerdatebegin, ['class' => 'datemask datepicker']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-1">
                    {!! Form::label('f_PartnerManagerController_date_end',  trans('strings.date_end_filter')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-2" style="margin-right: 2%">
                    {!! Form::text('f_PartnerManagerController_date_end', $studentreportcontrollerdateend, ['class' => 'datemask datepicker']  ) !!}
                </div>
                {!! Form::label('f_PartnerManagerController_studentgroup',  trans('strings.studentgroup'), ['class' => 'col-md-1']) !!}
                <div class="col-md-2">
                    {!! Form::text('f_PartnerManagerController_studentgroup', $partnermanagercontrollerstudentgroup, ['class' => 'form-control']  ) !!}
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-2">
                    <div>
                        <div class="sw-green create-permissions-switch">
                            <div class="onoffswitch">
                                <label class="control-label">{{ trans('strings.saap') }}</label>&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" value="1" name="f_PartnerManagerController_saap" class="toggleBtn onoffswitch-checkbox">
                                <label for="export_to_csv" class="onoffswitch-label">
                                    <div class="onoffswitch-inner"></div>
                                    <div class="onoffswitch-switch"></div>
                                </label>
                            </div>
                        </div><!--green checkbox-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <div class="sw-green create-permissions-switch">
                            <div class="onoffswitch">
                                <label class="control-label">{{ trans('strings.saap_in_lesson') }}</label>&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" value="1" name="f_PartnerManagerController_saap_in_lesson" class="toggleBtn onoffswitch-checkbox">
                                <label for="export_to_csv" class="onoffswitch-label">
                                    <div class="onoffswitch-inner"></div>
                                    <div class="onoffswitch-switch"></div>
                                </label>
                            </div>
                        </div><!--green checkbox-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div >
                        <div class="sw-green create-permissions-switch">
                            <div class="onoffswitch">
                                <label class="control-label">{{ trans('strings.rating') }}</label>&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" value="1" name="f_PartnerManagerController_proof" class="toggleBtn onoffswitch-checkbox">
                                <label for="export_to_csv" class="onoffswitch-label">
                                    <div class="onoffswitch-inner"></div>
                                    <div class="onoffswitch-switch"></div>
                                </label>
                            </div>
                        </div><!--green checkbox-->
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div >
                        <div class="sw-green create-permissions-switch">
                            <div class="onoffswitch">
                                <label class="control-label">{{ trans('validation.attributes.export_to_csv') }}</label>&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" value="1" name="f_PartnerManagerController_export_to_csv" class="toggleBtn onoffswitch-checkbox" id="export_to_csv" >
                                <label for="export_to_csv" class="onoffswitch-label">
                                    <div class="onoffswitch-inner"></div>
                                    <div class="onoffswitch-switch"></div>
                                </label>
                            </div>
                        </div><!--green checkbox-->
                    </div>
                </div>
            </div>
            <hr/>
            <div >
                {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="" width="">{{ trans('strings.partner') }}</th>
            <th colspan="" width="">{{ trans('strings.studentgroup') }}</th>
            <th colspan="" width="20%">{{ trans('strings.student') }}</th>
            <th width="">{{ trans('strings.user_email') }}</th>
            <th width="">{{ trans('strings.exam') }}</th>
            <th width="5%">{{ trans('strings.max_tries') }}</th>
            <th width="">{{ trans('strings.is_finished') }}</th>
            <th width="">{{ trans('menus.avg') }}</th>
        </tr>
        </thead>
    </table>
    <div class="clearfix"></div>
@stop