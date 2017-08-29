@extends ('backend.layouts.master')

@section ('title', trans('menus.workshop_management') . ' | ' . trans('menus.create_workshop'))

@section('page-header')
    <h1>
        {{ trans('menus.workshop_management') }}
        <small>{{ trans('menus.create_workshop') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.workshops.index', trans('menus.workshop')) !!}</li>
    <li class="active">{!! link_to_route('admin.workshops.create', trans('menus.create_workshop')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.workshops.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
            </div>

        </div><!--form control-->
    <div class="form-group">
        {!! Form::label('teachers', trans('strings.cordinators'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('teachers[]', $teachers->lists('name', 'id')->all() , null , ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('title' , trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="form-input col-md-4">
            {!! Form::select('courses[]', $courses->lists('title', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.course') ])  !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('content', trans('strings.content'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('content', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.content')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('minimum_grade', trans('strings.minimum_grade'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('minimum_grade', null, ['class' => 'form-control', 'placeholder' => trans('strings.minimum_grade')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('available_days_after_enrollment', trans('strings.available_days_after_enrollment'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('available_days_after_enrollment', null, ['class' => 'form-control', 'placeholder' => trans('strings.available_days_after_enrollment')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('available_date', trans('strings.available_date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('available_date', null, ['class' => 'form-control datepicker datemask', 'placeholder' => trans('strings.available_date')]) !!}
        </div>
    </div><!--form control-->


    <div class="pull-left">
            <a href="{{route('admin.workshops.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop