@extends ('backend.layouts.master')

@section ('title', trans('menus.subjectcourses'))



@section('page-header')
    <h1>
        {{ trans('menus.subjectcourses') }}
        <small>{{ trans('menus.all_subjectcourses') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.subjectcourses.index', trans('menus.subjectcourses')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.subjectcourses.addindex')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.add_course') }}
        </a>
        <a href="{{route('admin.subjects.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('strings.course') }}</th>
            <th>{{ trans('strings.exam') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($subjectcourses as $subjectcourse)
            <tr>
                <td>{!! ($subjectcourse->course != null ? $subjectcourse->course->title : '') !!}</td>
                <td>{!! ($subjectcourse->exam != null ? $subjectcourse->exam->title : '') !!}</td>
                <td>{!! $subjectcourse->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $subjectcourses->count() !!} {{ trans('crud.subjectcourses.total') }}
    </div>

    <div class="clearfix"></div>


@stop