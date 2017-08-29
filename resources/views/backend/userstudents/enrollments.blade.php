@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        {{ trans('menus.userstudent_management') }}
        <small>{{ trans('menus.active_userstudents') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
@stop

@section('content')
    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.userstudents.edit', $studentcoursecontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.edit_userstudents') }}</a>
        <a href="{{route('admin.userstudents.enrollments', $studentcoursecontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.courses') }}</a>
        <a href="{{route('admin.userstudents.exams', $studentcoursecontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.exams') }}</a>
        <a href="{{route('admin.userstudents.orders', $studentcoursecontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.orders') }}</a>
    </div>
    <br/>
    <br/>

    @if (sizeof($studentcourses) > 0 )
    <h2>{{ trans('strings.student_courses') }}</h2>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="50%">{{ trans('strings.course') }}</th>
            <th width="16%">{{ trans('strings.date_begin_enrollment') }}</th>
            <th width="16%">{{ trans('strings.date_end_enrollment') }}</th>
            <th width="18%">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($studentcourses as $studentcourse)
                <tr>
                    <td>{!! $studentcourse->course != null ? $studentcourse->course->title : "" !!}</td>
                    <td>{!! format_datebr($studentcourse->date_begin) . ' (' . diff_time( $studentcourse->date_begin ) . ')' !!}</td>
                    <td>{!! format_datebr($studentcourse->date_end) . ' (' . diff_time( $studentcourse->date_end ) . ')'!!}</td>
                    <td>{!! $studentcourse->lessons_button !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if (sizeof($studentmodules) > 0 )
    <h2>{{ trans('strings.student_modules') }}</h2>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="50%">{{ trans('strings.module') }}</th>
            <th width="16%">{{ trans('strings.date_begin_enrollment') }}</th>
            <th width="16%">{{ trans('strings.date_end_enrollment') }}</th>
            <th width="18%">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($studentmodules as $studentmodule)
            <tr>
                <td>{!! $studentmodule->module->name !!}</td>
                <td>{!! format_datebr($studentmodule->date_begin) . ' (' . diff_time( $studentmodule->date_begin ) . ')' !!}</td>
                <td>{!! format_datebr($studentmodule->date_end) . ' (' . diff_time( $studentmodule->date_end ) . ')'!!}</td>
                <td>{!! $studentmodule->lessons_button !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    @if (sizeof($studentlessons) > 0 )
    <h2>{{ trans('strings.student_lessons') }}</h2>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="50%">{{ trans('strings.lesson') }}</th>
            <th width="16%">{{ trans('strings.date_begin_enrollment') }}</th>
            <th width="16%">{{ trans('strings.date_end_enrollment') }}</th>
            <th width="18%">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($studentlessons as $studentlesson)
            <tr>
                <td>{!! $studentlesson->lesson->title !!}</td>
                <td>{!! format_datebr($studentlesson->date_begin) . ' (' . diff_time( $studentlesson->date_begin ) . ')' !!}</td>
                <td>{!! format_datebr($studentlesson->date_end) . ' (' . diff_time( $studentlesson->date_end ) . ')'!!}</td>
                <td>{!! $studentlesson->lessons_button !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif


    <div class="clearfix"></div>
@stop