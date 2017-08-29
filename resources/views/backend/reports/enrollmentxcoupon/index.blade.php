@extends ('backend.layouts.master')

@section ('name', trans('menus.workshops'))



@section('page-header')
    <h1>
        {{ trans('menus.workshops') }}
        <small>{{ trans('menus.all_workshops') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.workshops.index', trans('menus.workshops')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.workshops.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_workshop') }}
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
        {!! Form::open(array('route' => array('admin.enrollment.enrollmentvscoupon'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_EnrollmentController_coupon',  trans('strings.coupon'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-7">
                    {!! Form::text('f_EnrollmentController_coupon', $enrollmentcoupon, ['class' => 'form-control']  ) !!}
                </div>
            </div>
            {{--
                <hr>
                <div class="row">
                    {!! Form::label('f_EnrollmentController_date_begin',  trans('strings.date_begin'), ['class' => 'col-md-2 control-label']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="col-md-2">
                        {!! Form::text('f_EnrollmentController_date_begin', $enrollmentdatebegin, ['class' => 'datemask']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    {!! Form::label('f_EnrollmentController_date_end',  trans('strings.date_end'), ['class' => 'col-md-2 control-label']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="col-md-2" style = "padding-left: 0" >
                        {!! Form::text('f_EnrollmentController_date_end', $enrollmentdateend, ['class' => 'datemask']  ) !!}
                    </div>

                </div>
            --}}
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="30%">{{ trans('strings.student') }}</th>
            <th width="10%">{{ trans('strings.state') }}</th>
            <th width="20%">{{ trans('strings.coupon') }}</th>
            <th width="15%">{{ trans('strings.number_order') }}</th>
            <th width="10%">{{ trans('strings.date_registration') }}</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{!! $result->UserName !!}</td>
                    <td>{!! $result->UF !!}</td>
                    <td>{!! $result->Code !!}</td>
                    <td>{!! $result->OrderId !!}</td>
                    <td>{!! format_br($result->OrderCreated, "d/m/Y H:i:s") !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pull-left">
      {!! "Total de ". count($results) ." Matrícula(s)" !!}
    </div>

    <div class="pull-right">
{{--        {!! $workshops->render() !!}--}}
    </div>

    <div class="clearfix"></div>
@stop