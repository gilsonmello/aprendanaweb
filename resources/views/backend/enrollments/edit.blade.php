@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section('page-header')
    <h1>
        {{ trans('menus.enrollments.enrollment') }}
        <small>{{ trans('menus.enrollments.edit') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.enrollments.index', trans('menus.enrollments.enrollments')) !!}</li>
    <li class="active">{!! trans('menus.enrollments.edit') !!}</li>
@stop

@section('content')

    {!! Form::model($enrollment, ['route' => ['admin.enrollments.update', $enrollment->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('student', trans('strings.student'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text(null, $enrollment->student->name, ['readonly' => 'readonly', 'class' => 'form-control', 'placeholder' => trans('strings.student')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('course', trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text(null, $enrollment->course->title, ['readonly' => 'readonly', 'class' => 'form-control slug-from-title', 'placeholder' => trans('strings.course')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('strings.release_for_certification') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="release_for_certification" class="toggleBtn onoffswitch-checkbox" id="new-active">
                    <label for="new-featured" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->

    
    
        <div class="pull-left">
            <a href="{{route('admin.news.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop