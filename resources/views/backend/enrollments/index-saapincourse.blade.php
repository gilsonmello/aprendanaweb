@extends ('backend.layouts.master')

@section ('title', trans('menus.enrollments_saapincourse'))

@section('page-header')
    <h1>
        {{ trans('menus.enrollments_saapincourse') }}
        <small>{{ trans('menus.all_enrollments_saapincourse') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.enrollments.indexsaapincourse', trans('menus.enrollments_saapincourse')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.enrollments.createsaapincourse')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_enrollment_saapincourse') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.enrollments.id') }}</th>
            <th>{{ trans('crud.enrollments.product') }}</th>
            <th>{{ trans('strings.student') }}</th>
            <th>{{ trans('strings.created_by') }}</th>
            <th width="10%">{{ trans('crud.enrollments.date_begin') }}</th>
            <th width="10%">{{ trans('crud.enrollments.date_end') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($enrollments as $enrollment)
            <tr>
                <td>{!! $enrollment->id !!}</td>
                <td>{!! ($enrollment->course_id != null ? $enrollment->course->title : ($enrollment->exam_id != null ? $enrollment->exam->title : "")) !!}</td>
                <td>{!! ($enrollment->student_id != null ? $enrollment->student->name : "") !!}</td>
                <td>{!! ($enrollment->user_id_created_by != null ? $enrollment->createdBy->name : "") !!}</td>
                <td>{!! $enrollment->date_begin !!}</td>
                <td>{!! $enrollment->date_end !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $enrollments->total() !!} {{ trans('crud.enrollments.total_saapincourse') }}
    </div>

    <div class="pull-right">
        {!! $enrollments->render() !!}
    </div>

    <div class="clearfix"></div>
@stop