@extends ('backend.layouts.master')

@section ('title', trans('menus.section_management') . ' | ' . trans('menus.edit_section'))

@section('page-header')
    <h1>
        {{ trans('menus.sections') }}
        <small>{{ trans('menus.edit_section') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.sections.index', trans('menus.sections')) !!}</li>
    <li class="active">{!! link_to_route('admin.sections.create', trans('menus.edit_section')) !!}</li>
@stop

@section('content')

    {!! Form::model($section, ['route' => ['admin.sections.update', $section->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', $section->name, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.name')]) !!}
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
                    <input type="checkbox" value="1" name="active" class="toggleBtn onoffswitch-checkbox" id="package-active" @if($section->active == 1)checked="checked"@endif>
                    <label for="package-active" class="onoffswitch-label">
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
                    <input type="checkbox" value="1" name="show_tag_cloud" class="toggleBtn onoffswitch-checkbox" id="show-tag-cloud" @if($section->show_tag_cloud == true)checked="checked"@endif>
                    <label for="package-active" class="onoffswitch-label">
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
                {!! Form::text('color', $section->color, ['class' => 'form-control']) !!}
                <div class="input-group-addon">
                    <i></i>
                </div>
            </div>
        </div>

    <div class="form-group">
        {!! Form::label('addimg', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <a href="{!! $photooriginal !!}" target="_blank">
                <input type="file" name="addimg"/><br/>
                {!!   HTML::image($photoresize) !!}
            </a>
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