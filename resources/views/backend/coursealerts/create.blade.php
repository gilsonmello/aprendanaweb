@extends ('backend.layouts.master')

@section ('title', trans('menus.coursealert_management') . ' | ' . trans('menus.create_coursealert'))

@section('page-header')
    <h1>
        {{ trans('menus.coursealert_management') }}
        <small>{{ trans('menus.create_coursealert') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.coursealerts.index', trans('menus.coursealerts')) !!}</li>
    <li class="active">{!! link_to_route('admin.coursealerts.create', trans('menus.create_coursealert')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.coursealerts.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}


    <div class="form-group">
        {!! Form::label('course_id', trans('validation.attributes.courses'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('course_id', [''=>''] + $courses->lists('title', 'id')->all(), null, ['class' => 'select2']) !!}
        </div>
    </div>

        <div class="form-group">
            {!! Form::label('description', trans('validation.attributes.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {{--{!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}--}}
                {!! Form::textarea('description', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.description')]) !!}
            </div>
        </div><!--form control-->


        <div class="form-group">
            {!! Form::label('date', trans('validation.attributes.date'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('date', null, ['class' => 'form-control datepicker', 'placeholder' => trans('strings.date')]) !!}
            </div>
        </div><!--form control-->


    <div class="pull-left">
            <a href="{{route('admin.coursealerts.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
    </div>

    <div class="pull-right">
        <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
    </div>
    <div class="clearfix"></div>

      {!! Form::close() !!}
@stop