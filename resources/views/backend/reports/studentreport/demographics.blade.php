@extends ('backend.layouts.master')

@section ('title', trans('menus.student_demographics'))

@section('page-header')
    <h1>
        {{ trans('menus.student_demographics') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.studentreports.index', trans('menus.student_demographics')) !!}</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.studentreports.demographics'), 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                <div class="col-md-1">
                    {!! Form::label('f_StudentReportController_dim1',  trans('strings.dim1_filter')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-2">
                    {!! Form::select('f_StudentReportController_dim1', ['' => '','S' => trans('strings.state'),'G' => trans('strings.gender'),'A' => trans('strings.age')], $studentreportcontrollerdim1, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-1">
                    {!! Form::label('f_StudentReportController_dim2',  trans('strings.dim2_filter')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-2">
                    {!! Form::select('f_StudentReportController_dim2', ['' => '','S' => trans('strings.state'),'G' => trans('strings.gender'),'A' => trans('strings.age')], $studentreportcontrollerdim2, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-1">
                    {!! Form::label('f_StudentReportController_dim3',  trans('strings.dim3_filter')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-2">
                    {!! Form::select('f_StudentReportController_dim3', ['' => '','S' => trans('strings.state'),'G' => trans('strings.gender'),'A' => trans('strings.age')], $studentreportcontrollerdim3, ['class' => 'form-control']) !!}
                </div>
            </div>
            <hr/>
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
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-1">
                    {!! Form::label('$f_TeacherStatementController_user_id', trans('strings.course')) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::select('f_StudentReportController_course_id', [''=>''] + $courses->lists('title', 'id')->all(), $studentreportcontrollercourseid, ['class' => 'select2']) !!}
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @if ((isset($results)) and (count($results) != 0))
    <table class="table table-bordered table-hover" style="width: 500px;">
        <thead>
        <tr>
            <th width="80%">{{ trans('strings.dimension') }}</th>
            <th class="text-right"  width="10%">{{ trans('strings.count') }}</th>
            <th class="text-right"  width="10%">{{ trans('strings.percentage') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)

            <!--tr style="background-color: #3D8EBC; color: white;"-->
            <tr style="background-color: #8DB2D7">
                <td >{{ $result['title'] }}</td>
                <td class="text-right">{!! number_format($result['count'], 0, ',', '.' )!!}</td>
                <td class="text-right">{!! number_format($result['count'] / $countstudents * 100, 2, ',', '.' )!!} %</td>
            </tr>

            @if (isset($result['dim2']))
                @foreach ($result['dim2'] as $dim2)
                    <tr style="background-color: #A8BCD7">
                        <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $dim2['title'] }}</td>
                        <td class="text-right">{!! number_format($dim2['count'], 0, ',', '.' )!!}</td>
                        <td class="text-right">{!! number_format($dim2['count'] / $result['count'] * 100 , 2, ',', '.' )!!} %</td>
                    </tr>
                    @if (isset($dim2['dim3']))
                        @foreach ($dim2['dim3'] as $dim3)
                            <tr style="background-color: #A5CED7">
                                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $dim3['title'] }}</td>
                                <td class="text-right">{!! number_format($dim3['count'], 0, ',', '.' )!!}</td>
                                <td class="text-right">{!! number_format($dim3['count'] / $dim2['count'] * 100 , 2, ',', '.' )!!} %</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>
    @endif

    <br/>
    <b>{{ trans('strings.students') }}:</b> {!! number_format($countstudents, 0, ',', '.' )!!}
    <div class="clearfix"></div>
@stop