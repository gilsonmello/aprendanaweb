@extends ('backend.layouts.master')

@section ('title', trans('menus.student_performance'))

@section('page-header')
    <h1>
        {{ trans('menus.student_performance') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.studentreports.index', trans('menus.student_performance')) !!}</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.studentreports.index'), 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                <div class="col-md-1">
                    {!! Form::label('f_StudentReportController_date_begin',  trans('strings.date_begin_filter')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-2">
                    {!! Form::text('f_StudentReportController_date_begin', $studentreportcontrollerdatebegin, ['class' => 'datemask']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-1">
                    {!! Form::label('f_StudentReportController_date_end',  trans('strings.date_end_filter')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-2">
                    {!! Form::text('f_StudentReportController_date_end', $studentreportcontrollerdateend, ['class' => 'datemask']  ) !!}
                </div>
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    {!! Form::label('f_StudentReportController_couponcode', trans('strings.code_coupon')) !!}
                </div>
                <div class="col-md-2">
                    <div class="col-md-2">
                        {!! Form::text('f_CouponController_coupon_code', $studentreportcontrollercouponcode, ['class' => '']  ) !!}
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-1">
                    {!! Form::label('f_TeacherStatementController_user_id', trans('strings.course')) !!}
                </div>
                <div class="col-md-9">
                    {!! Form::select('f_StudentReportController_course_id', $courses->lists('title', 'id'), $studentreportcontrollercourseid, ['class' => 'select2']) !!}
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-1">
                    {!! Form::label('f_StudentReportController_studentname', trans('strings.name')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::text('f_StudentReportController_studentname', $studentreportcontrollerstudentname, null  ) !!}
                </div>
                <div class="col-md-1">
                    {!! Form::label('f_TeacherStatementController_user_id', trans('strings.partner')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('f_StudentReportController_partner_id',['' => '-']  +   $partners->lists('name', 'id')->all(), $studentreportcontrollerpartnerid, ['class' => 'select2']) !!}
                </div>
                <div class="col-md-1">
                    {!! Form::label('f_TeacherStatementController_user_id', trans('strings.studentgroup')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::text('f_StudentReportController_studentgroup', $studentreportcontrollerstudentgroup, null  ) !!}
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
            <th colspan="2" width="30%">{{ trans('strings.student') }}</th>
            <th colspan="2" width="30%">{{ trans('strings.course') }}</th>
            <th width="10%">{{ trans('strings.date_begin') }}</th>
            <th width="10%">{{ trans('strings.date_end') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.block_total') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.block_views') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.percentage_course') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.pace_week') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.percentage_to_finish') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.pace_needed') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)

                <!--tr style="background-color: #3D8EBC; color: white;"-->
                <tr >
                    <td colspan="2" >
                        {{ $result->student->name != '' ? $result->student->name : $result->student->email }}
                    </td>
                    <td colspan="2" >
                        {{ $result->course != null ? $result->course->title : "" }}
                    </td> 
                    <td>{!! format_datebr($result->date_begin) !!}</td>
                    <td>{!! format_datebr($result->date_end) !!}</td>
                    <td class="text-right">{!! number_format($result->contents, 0, ',', '.' )!!}</td>
                    <td class="text-right">{!! number_format($result->count_views, 0, ',', '.' )!!}</td>
                    <td class="text-right">{!! number_format($result->percent_finished, 0, ',', '.' )!!} %</td>
                    <td class="text-right">{!! number_format($result->pace_per_week, 0, ',', '.' )!!} p/s</td>
                    <td class="text-right">{!! number_format(100 - $result->percent_finished, 0, ',', '.' )!!} %</td>
                    <td class="text-right">{!! $result->pace_needed === -1 ? '-' : number_format($result->pace_needed, 0, ',', '.' ) . ' p/s' !!}</td>
                </tr>

                @if ($studentreportcontrollerdetail == 1)
                    @foreach ($result->views as $view)
                        <tr>
                            <td width="5%"></td>
                            <td colspan="4" >
                            @if ($view->content != null && $view->content->lesson != null && $view->content->lesson->module != null)
                                {!! $view->content->lesson->module->name == null ? "" :  $view->content->lesson->module->name  !!} -
                            @endif
                            @if ($view->content != null && $view->content->lesson != null)
                                Aula {!! $view->content->lesson->sequence!!} -
                            @endif
                            @if ($view->content != null)
                                Bloco {!! $view->content->sequence !!}
                            @endif
                            </td>
                            <td class="text-right">{!! number_format($view->percent, 0, ',', '.' )!!}</td>
                            <td colspan="4"></td>
                        </tr>
                    @endforeach
                @endif
        @endforeach
        </tbody>
    </table>

    <br/>
    <b>{{ trans('strings.students') }}:</b> {!! number_format($countstudents, 0, ',', '.' )!!}
    <div class="clearfix"></div>
@stop