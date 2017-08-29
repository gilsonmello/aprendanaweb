@extends ('backend.layouts.master')

@section ('title', trans('menus.video_management') . ' | ' . trans('menus.create_video'))

@section('page-header')
    <h1>
        {{ trans('menus.video_management') }}
        <small>{{ trans('menus.create_video') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.videos.index', trans('menus.videos')) !!}</li>
    <li class="active">{!! link_to_route('admin.videos.create', trans('menus.create_video')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.videos.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('title', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.title')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('slug', trans('validation.attributes.slug'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('slug', null, ['class' => 'form-control slug-from-title', 'placeholder' => trans('strings.slug')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('url', trans('validation.attributes.url'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => trans('strings.url')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('activation_date', trans('validation.attributes.activation_date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('activation_date', null, ['class' => 'form-control datepicker', 'placeholder' => trans('validation.attributes.activation_date')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('content', trans('validation.attributes.content'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('content', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.content')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('teachers', trans('validation.attributes.teacher'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('teachers[]', $teachers->lists('name', 'id'), null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('tags', trans('validation.attributes.tags'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('tags[]', [], [], ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="img"/>
        </div><!-- /.col -->
    </div>

    @if(access()->hasRole('Administrador'))
        <div class="form-group">
            <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
            <div class="col-lg-1">
                <div class="sw-green create-permissions-switch">
                    <div class="onoffswitch">
                        <input type="checkbox" value="1" name="status" class="toggleBtn onoffswitch-checkbox" id="video-active" checked="checked">
                        <label for="video-active" class="onoffswitch-label">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div><!--green checkbox-->
            </div>
        </div><!--form control-->
    @endif

    <div class="pull-left">
        <a href="{{route('admin.videos.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
    </div>

    <div class="pull-right">
        <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
    </div>
    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop