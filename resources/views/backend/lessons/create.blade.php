@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        {{ trans('menus.lesson_management') }}
        <small>{{ trans('menus.create_lesson') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.lessons.index', trans('menus.lessons')) !!}</li>
    <li class="active">{!! link_to_route('admin.lessons.create', trans('menus.create_lesson')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.lessons.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('subsection_id', trans('validation.attributes.subsection'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('subsection_id', $subsections, null, ['class' => 'form-control']) !!}
            </div><!-- /.col -->
        </div>

        <div class="form-group">
            {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
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
            {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <input type="file" name="featured_img"/>
            </div><!-- /.col -->
        </div>

        <div class="form-group">
            {!! Form::label('video', trans('validation.attributes.video'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('video_ad_url', null, ['class' => 'form-control', 'placeholder' => trans('strings.video')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('price', trans('validation.attributes.price'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('price', null, ['class' => 'form-control money', 'placeholder' => trans('strings.price')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('discount_price', trans('validation.attributes.discount_price'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('discount_price', null, ['class' => 'form-control money', 'placeholder' => trans('strings.discount_price')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('sequence', trans('validation.attributes.sequence'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('sequence', null, ['class' => 'form-control', 'placeholder' => trans('strings.sequence')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('duration', trans('validation.attributes.duration'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('duration', null, ['class' => 'form-control', 'placeholder' => trans('strings.duration')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('tags', trans('validation.attributes.tags'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('tags[]', [], [], ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('activation_date', trans('validation.attributes.activation_date'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('activation_date', null, ['class' => 'form-control datepicker', 'placeholder' => trans('validation.attributes.activation_date')]) !!}
            </div>
        </div><!--form control-->

        <div class="pull-left">
            <a href="{{route('admin.lessons.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop