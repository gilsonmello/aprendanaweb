@extends ('backend.layouts.master')

@section ('title', trans('menus.workshopgrouptutor_management') . ' | ' . trans('menus.create_workshopgrouptutor'))

@section('page-header')
    <h1>
        {{ trans('menus.workshopgrouptutor_management') }}
        <small>{{ trans('menus.create_workshopgrouptutor') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.workshopgrouptutors.index', trans('menus.workshopgrouptutor')) !!}</li>
    <li class="active">{!! link_to_route('admin.workshopgrouptutors.create', trans('menus.create_workshopgrouptutor')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.workshopgrouptutors.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}


    <div class="form-group">
        {!! Form::label('tutor' , trans('strings.tutor'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="form-input col-md-4">
            {!! Form::select('tutors[]', $tutors->lists('name', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.tutor') ])  !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('activity' , trans('strings.activity'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="form-input col-md-4">
            {!! Form::select('activities[]', $activities->lists('description', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.activity') ])  !!}
        </div>
    </div>

    <div class="pull-left">
            <a href="{{route('admin.workshopgrouptutors.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop