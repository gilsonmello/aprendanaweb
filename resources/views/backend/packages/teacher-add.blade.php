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
        <a href="{{route('admin.packageteachers.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    {!! Form::open(['route' => 'admin.packageteachers.add', 'id' => 'update-teacher-form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
        <div class="form-group form-teachers" style="margin:20px 0;">

            {!! Form::label('name' , trans('validation.attributes.teacher'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="form-input col-md-4">
                {!! Form::select('teachers[]', $teachers->lists('name', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.teacher') ])  !!}
            </div>
            <div class="form-input col-sm-4">
                {!! Form::text('percentage' , 100, ['class' => 'form-control teacher-percentage', 'placeholder' => trans('strings.percentage')]) !!}
            </div>
        </div>
            <div class="pull-left">
                <a href="{{route('admin.packageteachers.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
            </div>

            <div class="pull-right">
                <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
            </div>

    {!! Form::close() !!}
    <div class="clearfix"></div>
@stop