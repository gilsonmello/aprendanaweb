@extends ('backend.layouts.master')

@section ('title', trans('menus.enrollments.enrollments'))

@section('page-header')
    <h1>
        {{ trans('menus.enrollments.enrollments') }}
        <small>{{ trans('menus.enrollments.all') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.enrollments.enrollments') !!}</li>
@stop

@section('content')
    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.enrollments.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                <div class="col-md-2" style="padding-right: 0; width: 12%">
                    {!! Form::label('f_EnrollmentController_name_or_email',  trans('strings.name_or_email'), []) !!}
                </div>
                <div class="col-md-4" style="padding-right: 0; padding-left: 0">
                    {!! Form::text('f_EnrollmentController_name_or_email', $nameoremail, ['class' => 'form-control']  ) !!}
                </div>
                <div class="col-md-1">
                        {!! Form::label('f_EnrollmentController_course_id',  trans('strings.courses'), []) !!}
                    </div>
                <div class="col-md-5">
                        {!! Form::select('f_EnrollmentController_course_id', ['' => ''] + $courses->lists('title', 'id')->all(), $courseid, ['class' => 'select2']) !!}
                    </div>
            </div>
            <hr style="margin-top: 10px">
            <div class="row">
                <div class="col-md-1">
                    {!! Form::label('f_EnrollmentController_date_begin',  trans('strings.date_begin'), []) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::text('f_EnrollmentController_date_begin', $datebegin, ['class' => 'datemask datepicker']) !!}
                </div>
                <div class="col-md-1">
                    {!! Form::label('f_EnrollmentController_date_end',  trans('strings.date_end'), []) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::text('f_EnrollmentController_date_end', $dateend, ['class' => 'datemask datepicker']) !!}
                </div>
                <div class="col-md-3">
                    <div>
                        <div class="sw-green create-permissions-switch">
                            <div class="onoffswitch">
                                <label class="control-label" for="released_for_certification">{{ trans('strings.released_for_certification') }}</label>&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" value="1" name="f_EnrollmentController_released_for_certification" class="toggleBtn onoffswitch-checkbox" id="released_for_certification" @if(!empty($releasedforcertification)) checked="checked" @endif>
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
            <th>{{ trans('crud.courses.title') }}</th>
            <th>{{ trans('strings.student') }}</th>
            <th>{{ trans('strings.email') }}</th>
            <th>{{ trans('strings.date_begin') }}</th>
            <th>{{ trans('strings.date_end') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($enrollments as $value)
                <tr>
                    <td>{!! $value->course->title !!}</td>
                    <td>{!! $value->students_name !!}</td>
                    <td>{!! $value->students_email !!}</td>
                    <td>{!! format_datebr($value->date_begin) !!}</td>
                    <td>{!! format_datebr($value->date_end) !!}</td>
                    {{--<td class="text-right" >{!! number_format($course->price, 2, ',', '.' ) !!}</td>
                    <td class="text-right" >{!! number_format($course->average_grade, 2, ',', '.' )  !!}</td>
                    <td class="text-right" >{!!  number_format($course->orders_count, 0, ',', '.' )   !!}</td>--}}
                    <td>{!! $value->action_buttons !!}</td>
                </tr>
            @endforeach 
        </tbody>
    </table>

    <div class="pull-left">
        {{ trans('menus.enrollments.total') }}(s) = {!! $enrollments->total() !!}  
    </div>

    <div class="pull-right">
        {!! $enrollments->render() !!}
    </div>

    <div class="clearfix"></div>
@stop