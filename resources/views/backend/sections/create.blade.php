@extends ('backend.layouts.master')

@section ('title', trans('menus.section_management') . ' | ' . trans('menus.create_section'))

@section('page-header')
    <h1>
        {{ trans('menus.section_management') }}
        <small>{{ trans('menus.create_section') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.sections.index', trans('menus.sections')) !!}</li>
    <li class="active">{!! link_to_route('admin.sections.create', trans('menus.create_section')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.sections.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.name')]) !!}
            </div>

        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('slug', trans('validation.attributes.slug'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('slug', null, ['class' => 'form-control slug-from-title', 'placeholder' => trans('strings.slug')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('menu_name', trans('strings.menu_name'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('menu_name', null, ['class' => 'form-control', 'placeholder' => trans('strings.menu_name')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('sequence', trans('strings.sequence'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('sequence', null, ['class' => 'form-control', 'placeholder' => trans('strings.sequence')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('banner', trans('Banner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('banner', null, ['class' => 'form-control', 'placeholder' => trans('Banner')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="active" class="toggleBtn onoffswitch-checkbox" id="section-active" checked="checked">
                    <label for="section-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->


    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.tag-cloud') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="0" name="tagcloud" class="toggleBtn onoffswitch-checkbox" id="show-tag-cloud">
                    <label for="section-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->



    <div class="form-group">
            {!! Form::label('color', trans('validation.attributes.color'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-5 input-group colorpicker-box colorpicker-element">
                {!! Form::text('color', null, ['class' => 'form-control']) !!}
                <div class="input-group-addon">
                    <i></i>
                </div>
            </div>
        </div>


    <div class="form-group">
        {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="imgadd"/>
        </div><!-- /.col -->
    </div>

        <div class="pull-left">
            <a href="{{route('admin.sections.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop