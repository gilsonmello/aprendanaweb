@extends ('backend.layouts.master')

@section ('name', trans('menus.subjects'))



@section('page-header')
    <h1>
        {{ trans('menus.subjects') }}
        <small>{{ trans('menus.all_subjects') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.subjects.index', trans('menus.subjects')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.subjects.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_subject') }}
        </a>
        <a href="{{route('admin.subjectcourses.conference')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.conference_courses') }}
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
        {!! Form::open(array('route' => array('admin.subjects.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                <div class="col-md-2 control-label">
                    {!! Form::label('f_SubjectController_id', trans('strings.subject_father')) !!}
                </div>
                <div class="col-md-5">
                    {!! Form::select('f_SubjectController_subject_id', ['' => ''] + $subject1and2->lists('name', 'id')->all(), $subjectcontrollersubjectid, ['class' => 'form-control select2']) !!}
                </div>
            </div>
        </div>
        <hr/>
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_SubjectController_name',  trans('strings.name'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_SubjectController_name', $subjectcontrollername, ['class' => 'form-control']  ) !!}
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
            <th width="40%">{{ trans('crud.subjects.name') }}</th>
            <th width="40%">{{ trans('crud.subjects.parent') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($subjects as $subject)
            <tr>
                <td>{!! $subject->name !!}</td>
                <td>{!! ($subject->parent != null ? $subject->parent->name : "") !!}</td>
                <td>{!! $subject->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $subjects->total() !!} {{ trans('crud.subjects.total') }}
    </div>

    <div class="pull-right">
        {!! $subjects->render() !!}
    </div>

    <div class="clearfix"></div>
@stop