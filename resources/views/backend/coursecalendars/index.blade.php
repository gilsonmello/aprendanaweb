@extends ('backend.layouts.master')

@section ('title', trans('menus.coursecalendars'))

@section('page-header')
    <h1>
        {{ trans('menus.coursecalendars') }}
        <small>{{ trans('menus.all_coursecalendars') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.coursecalendars.index', trans('menus.coursecalendars')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.coursecalendars.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_coursecalendar') }}
        </a>
        {{--<a href="{{route('admin.coursecalendars.import')}}" class="btn btn-primary btn-xs">--}}
            {{--{{ trans('menus.import_coursecalendar') }}--}}
        {{--</a>--}}
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.coursecalendars.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_CourseCalendarController_course_id',  trans('strings.course'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::select('f_CourseCalendarController_course_id', [''=>''] + $courses->lists('title', 'id')->all(), $coursecalendarcontrollercourseid, ['class' => 'select2']) !!}
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
            <th>{{ trans('crud.coursecalendars.course') }}</th>
            <th>{{ trans('crud.coursecalendars.date') }}</th>
            <th>{{ trans('crud.coursecalendars.description') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($coursecalendars as $coursecalendar)
            <tr>
                <td>{!! $coursecalendar->course->title !!}</td>
                <td>{!! format_datebr($coursecalendar->date) !!}</td>
                <td>{!! $coursecalendar->description !!}</td>
                <td>{!! $coursecalendar->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $coursecalendars->total() !!} {{ trans('crud.coursecalendars.total') }}
    </div>

    <div class="pull-right">
        {!! $coursecalendars->render() !!}
    </div>

    <div class="clearfix"></div>
@stop