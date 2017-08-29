@extends ('backend.layouts.master')

@section ('title', trans('menus.reports.coursereport_sales'))

@section('page-header')
    <h1>
        {{ trans('menus.teacher_payment') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.teacherpaymentreports.index', trans('menus.teacher_payment')) !!}</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.teacherpaymentreports.index'), 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                <div class="col-md-6">
                    {!! Form::label('f_TeacherPaymentReportController_date_begin',  trans('strings.date_begin')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::text('f_TeacherPaymentReportController_date_begin', $teacherpaymentreportcontrollerdatebegin, ['class' => 'datemask']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="clearfix visible-xs"></div>
                    {!! Form::label('f_TeacherPaymentReportController_date_end',  trans('strings.date_end')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::text('f_TeacherPaymentReportController_date_end', $teacherpaymentreportcontrollerdateend, ['class' => 'datemask']  ) !!}
                </div>

                <div class="col-md-3">
                    {!! Form::label('f_TeacherPaymentReportController_detail',  trans('strings.type')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::radio('f_TeacherPaymentReportController_detail', '0',($teacherpaymentreportcontrollerdetail ===  '0' ? true : false)) !!} {!!trans('strings.simple')!!}&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="clearfix visible-xs"></div>
                    {!! Form::radio('f_TeacherPaymentReportController_detail', '1',($teacherpaymentreportcontrollerdetail ===  '1' ? true : false)) !!} {!!trans('strings.detailed')!!}
                </div>
                <div class="col-md-3">
                    {!! Form::label('f_TeacherPaymentReportController_itens',  trans('strings.itens')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::text('f_TeacherPaymentReportController_itens', $teacherpaymentreportcontrolleritens) !!}
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
            <th colspan="3">{{ trans('strings.teacher') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.total_sales') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.count_sales') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.average_sales') }}</th>
            <th class="text-right"  width="6%">{{ trans('strings.percent_of_sales') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)

            @if ($result->total_sales != 0)
                <tr style="background-color: #A8BCD7; color: black;">
                    <td colspan="3" >{{ $result->name }}</td>
                    <td class="text-right">{!! number_format($result->total_sales, 2, ',', '.' )!!}</td>
                    <td class="text-right">{!! number_format($result->count_sales, 0, ',', '.' )!!}</td>
                    <td class="text-right">{!! number_format($result->average_sales, 2, ',', '.' )!!}</td>
                    <td class="text-right">{!! number_format($totalsales == 0 ? 0 : $result->total_sales / $totalsales * 100, 2, ',', '.' )!!}</td>
                </tr>

                @if ($teacherpaymentreportcontrollerdetail == 1)
                    @foreach ($result->payments as $payment)

                        <tr>
                            <td width="5%"></td>
                            <td>{!! $payment->product_name == null ? "" : $payment->product_name  !!}</td>
                            <td>{!! format_datebr($payment->date) !!}</td>
                            <td class="text-right">{!! number_format($payment->value, 2, ',', '.' )!!}</td>
                            <td colspan="3"></td>
                        </tr>
                    @endforeach
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