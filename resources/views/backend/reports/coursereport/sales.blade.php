@extends ('backend.layouts.master')

@section ('title', trans('menus.reports.coursereport_sales'))

@section('page-header')
    <h1>
        {{ trans('menus.course_sales') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.coursereports.sales', trans('menus.course_sales')) !!}</li>
@stop

@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.coursereports.sales'), 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                <div class="col-md-12">
                    {!! Form::label('f_CourseReportController_date_begin',  trans('strings.date_begin')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::text('f_CourseReportController_date_begin', $coursereportcontrollerdatebegin, ['class' => 'datemask']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::label('f_CourseReportController_date_end',  trans('strings.date_end')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::text('f_CourseReportController_date_end', $coursereportcontrollerdateend, ['class' => 'datemask']  ) !!}
                    {!! Form::label('f_CourseReportController_detail',  trans('strings.type')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::radio('f_CourseReportController_detail', '0',($coursereportcontrollerdetail ===  '0' ? true : false)) !!} {!!trans('strings.simple')!!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::radio('f_CourseReportController_detail', '1',($coursereportcontrollerdetail ===  '1' ? true : false)) !!} {!!trans('strings.detailed')!!}
                </div>
            </div>
            <br>
                <div class="row">
                    <div class="col-md-1">
                        {!! Form::label('f_TeacherStatementController_user_id', trans('strings.partner')) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::select('f_CourseReportController_partner_id',['' => '-']  +   $partners->lists('name', 'id')->all(), $coursereportcontrollerpartnerid, ['class' => 'select2']) !!}
                    </div>

                    <div class="col-md-3">
                        <div >
                            <div class="sw-green create-permissions-switch">
                                <div class="onoffswitch">
                                    <label class="control-label">{{ trans('strings.only_paid') }}</label>
                                    <input type="checkbox" value="1" name="f_CourseReportController_only_paid" class="toggleBtn onoffswitch-checkbox" id="only_paid"  @if($coursereportcontrolleronlypaid != null && $coursereportcontrolleronlypaid == '1')checked="checked"@endif >
                                    <label for="only_paid" class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div><!--green checkbox-->
                        </div>
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('f_CourseReportController_itens',  trans('strings.itens')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                        {!! Form::text('f_CourseReportController_itens', $coursereportcontrolleritens) !!}
                    </div>
            </div>
            <div class="box-footer">
                {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="4">{{ trans('strings.course') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.total_sales') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.count_sales') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.average_sales') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.percent_of_sales') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)

            @if ($result->count_sales != 0)
                <tr style="background-color: #A8BCD7; color: black;">
                    <td colspan="4" >{{ $result->title }}</td>
                    <td class="text-right">{!! number_format($result->total_sales, 2, ',', '.' )!!}</td>
                    <td class="text-right">{!! number_format($result->count_sales, 0, ',', '.' )!!}</td>
                    <td class="text-right">{!! number_format($result->average_sales, 2, ',', '.' )!!}</td>
                    <td class="text-right">{!! number_format($totalsales == 0 ? 0 : $result->total_sales / $totalsales * 100, 2, ',', '.' )!!}</td>
                </tr>

                @if ($coursereportcontrollerdetail == 1)
                    @if(count($result->ordercourses) != 0)
                        @foreach ($result->ordercourses as $ordercourse)
                            <tr>
                                <td width="5%"></td>
                                <td>{!! $ordercourse->order_id !!}</td>
                                <td>{!! $ordercourse->student_name . " [".$ordercourse->student_email."]" !!}</td>
                                <td>{!! format_datebr($ordercourse->order_date_registration) !!}</td>
                                <td class="text-right">{!! number_format($ordercourse->discount_price, 2, ',', '.' )!!}</td>
                                <td colspan="2">{!! $ordercourse->student_cel!!}</td>
                            </tr>
                        @endforeach
                    @endif
                @endif
            @endif
        @endforeach
        </tbody>
    </table>

    <br/>
    <b>{{ trans('strings.total_sales') }}:</b> {!! number_format($totalsales, 2, ',', '.' )!!}
    <br/>
    <b>{{ trans('strings.count_sales') }}:</b> {!! number_format($countsales, 0, ',', '.' )!!}
    <br/>
    <b>{{ trans('strings.average_sales') }}:</b>  {!! number_format( $countsales == 0 ? 0 : $totalsales / $countsales, 2, ',', '.' )!!}

    <div class="clearfix"></div>
@stop