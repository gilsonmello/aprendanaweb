@extends ('backend.layouts.master')

@section ('name', trans('menus.exams'))



@section('page-header')
    <h1>
        {{ trans('menus.exams') }}
        <small>{{ trans('menus.all_exams') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.exams.index', trans('menus.exams')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.examcourses.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    {!! Form::open(['route' => 'admin.examcourses.add', 'id' => 'update-course-form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
        <div class="form-group form-courses" style="margin:20px 0;">

            {!! Form::label('title' , trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="form-input col-md-4">
                {!! Form::select('courses[]', $courses->lists('title', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.course') ])  !!}
            </div>
        </div>
            <div class="pull-left">
                <a href="{{route('admin.examcourses.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
            </div>

            <div class="pull-right">
                <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
            </div>

    {!! Form::close() !!}
    <div class="clearfix"></div>
@stop