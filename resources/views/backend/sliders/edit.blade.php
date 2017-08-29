@extends ('backend.layouts.master')

@section ('name', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section('page-header')
    <h1>
        {{ trans('menus.sliders') }}
        <small>{{ trans('menus.edit_slider') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.sliders.index', trans('menus.sliders')) !!}</li>
    <li class="active">{!! link_to_route('admin.sliders.create', trans('menus.edit_slider')) !!}</li>
@stop

@section('content')

    {!! Form::model($slider, ['route' => ['admin.sliders.update', $slider->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control name-has-url', 'placeholder' => trans('strings.name')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('url', trans('validation.attributes.url'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => trans('strings.url')]) !!}
            </div>
        </div><!--form control-->


    <div class="form-group">
        {!! Form::label('orientation', trans('validation.attributes.orientation'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('orientation', 'L', true) !!}  {!! trans('strings.left') !!}&nbsp;&nbsp;
            {!! Form::radio('orientation', 'R') !!} {!! trans('strings.right') !!}&nbsp;&nbsp;
            {!! Form::radio('orientation', 'C') !!} {!! trans('strings.center') !!}&nbsp;&nbsp;

        </div>
    </div><!--form control-->


    <div class="form-group">
            {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! $slider->img_html['size200'] !!}
                <input type="file" name="img"/>
            </div><!-- /.col -->
        </div>

        <div class="pull-left">
            <a href="{{route('admin.sliders.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop