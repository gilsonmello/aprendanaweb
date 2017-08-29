@extends ('backend.layouts.master')

@section ('title', trans('menus.coursealerts'))

@section('page-header')
    <h1>
        {{ trans('menus.coursealerts') }}
        <small>{{ trans('menus.all_coursealerts') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.coursealerts.index', trans('menus.coursealerts')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.coursealerts.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_coursealert') }}
        </a>
        {{--<a href="{{route('admin.coursealerts.import')}}" class="btn btn-primary btn-xs">--}}
            {{--{{ trans('menus.import_coursealert') }}--}}
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
        {!! Form::open(array('route' => array('admin.coursealerts.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_CourseAlertController_course_id',  trans('strings.course'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::select('f_CourseAlertController_course_id', [''=>''] + $courses->lists('title', 'id')->all(), $coursealertcontrollercourseid, ['class' => 'select2']) !!}
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
            <th width="20%">{{ trans('crud.coursealerts.course') }}</th>
            <th width="8%">{{ trans('crud.coursealerts.date') }}</th>
            <th width="55%">{{ trans('crud.coursealerts.description') }}</th>
            <th width="8%">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($coursealerts as $coursealert)
            <tr>
                <td>{!! ($coursealert->course != null ? $coursealert->course->title : "<b>GERAL</b>") !!}</td>
                <td>{!! format_datebr($coursealert->date) !!}</td>
                <td>{!! $coursealert->description !!}</td>
                <td>{!! $coursealert->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $coursealerts->total() !!} {{ trans('crud.coursealerts.total') }}
    </div>

    <div class="pull-right">
        {!! $coursealerts->render() !!}
    </div>

    <div class="clearfix"></div>
@stop