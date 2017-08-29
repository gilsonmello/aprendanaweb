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


    {!! Form::open(['route' => 'admin.subjectcourses.add', 'id' => 'update-course-form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
        <div class="form-group form-courses" style="margin:20px 0;">

            {!! Form::label('title' , trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="form-input col-md-4">
                {!! Form::select('courses[]', $courses->lists('title', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.course') ])  !!}
            </div>
            {!! Form::label('title' , trans('strings.exam'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="form-input col-md-4">

                {!! Form::select('exams[]', [''=>''] + $exams->lists('title', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.exam') ])  !!}
            </div>
        </div>
            <div class="pull-left">
                <a href="{{route('admin.subjectcourses.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
            </div>

            <div class="pull-right">
                <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
            </div>

    {!! Form::close() !!}
    <div class="clearfix"></div>
@stop