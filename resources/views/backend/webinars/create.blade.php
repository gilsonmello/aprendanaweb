@extends ('backend.layouts.master')

@section ('title', trans('menus.webinars.webinar_management') . ' | ' . trans('menus.webinars.webinar_create'))

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        {{ trans('menus.webinars.webinar_management') }}
        <small>{{ trans('menus.webinars.webinar_create') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.webinars.index', trans('menus.webinars.all_webinar')) !!}</li>
    <li class="active">{{trans('menus.webinars.webinar_create')}}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.webinars.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}


        <div class="form-group">
            {!! Form::label('title' , trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="form-input col-md-4">
                {!! Form::select('courses_id', $courses->lists('title', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.course') ])  !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', null, ['class' => 'form-control name-has-url', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('description', trans('validation.attributes.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="box-body" style="padding: 0px;">
                    {!! Form::textarea('description', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.description')]) !!}
                </div>
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('youtube_live_url', trans('strings.url'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('youtube_live_url', null, ['class' => 'form-control', 'placeholder' => trans('strings.url')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('url', trans('validation.attributes.date_begin'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-2">
                {!! Form::text('date', null, ['class' => 'form-control datemask']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div><!--form control-->




        <div class="pull-left">
            <a href="{{route('admin.webinars.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop