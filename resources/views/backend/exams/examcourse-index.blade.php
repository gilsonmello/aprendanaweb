@extends ('backend.layouts.master')

@section ('title', trans('menus.examcourses'))



@section('page-header')
    <h1>
        {{ trans('menus.examcourses') }}
        <small>{{ trans('menus.all_examcourses') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.examcourses.index', trans('menus.examcourses')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.examcourses.addindex')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.add_course') }}
        </a>
        <a href="{{route('admin.exams.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('strings.title') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($examcourses as $examcourse)
            <tr>
                <td>{!! ($examcourse->course != null ? $examcourse->course->title : '') !!}</td>
                <td>{!! $examcourse->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $examcourses->count() !!} {{ trans('crud.examcourses.total') }}
    </div>

    <div class="clearfix"></div>


@stop