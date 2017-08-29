@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        {{ trans('menus.userstudent_management') }}
        <small>{{ trans('strings.student_exams') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.access.users.index', trans('strings.student_exams')) !!}</li>
@stop

@section('content')
    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.userstudents.edit', $studentexamcontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.edit_userstudents') }}</a>
        <a href="{{route('admin.userstudents.enrollments', $studentexamcontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.courses') }}</a>
        <a href="{{route('admin.userstudents.exams', $studentexamcontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.exams') }}</a>
        <a href="{{route('admin.userstudents.orders', $studentexamcontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.orders') }}</a>
    </div>
    <br/>
    <br/>

    @if (sizeof($studentexams) > 0 )

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="40%">{{ trans('strings.exam') }}</th>
            <th width="16%">{{ trans('strings.date_begin_enrollment') }}</th>
            <th width="16%">{{ trans('strings.date_end_enrollment') }}</th>
            <th width="5%">{{ trans('strings.exam_max_tries') }}</th>
            <th width="5%">{{ trans('strings.exam_tries') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($studentexams as $studentexam)
                <tr>
                    <td>{!! $studentexam->exam != null ? $studentexam->exam->title : "" !!}</td>
                    <td>{!! format_datebr($studentexam->date_begin) . ' (' . diff_time( $studentexam->date_begin ) . ')' !!}</td>
                    <td>{!! format_datebr($studentexam->date_end) . ' (' . diff_time( $studentexam->date_end ) . ')'!!}</td>
                    <td>{!! $studentexam->exam_max_tries !!}</td>
                    <td>{!! count($studentexam->executions) !!}</td>
                    <td>{!! $studentexam->exam_button !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="clearfix"></div>
@stop