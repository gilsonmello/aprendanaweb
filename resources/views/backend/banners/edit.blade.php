@extends ('backend.layouts.master')

@section ('name', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section('page-header')
    <h1>
        {{ trans('menus.banners') }}
        <small>{{ trans('menus.edit_banner') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.banners.index', trans('menus.banners')) !!}</li>
    <li class="active">{!! link_to_route('admin.banners.create', trans('menus.edit_banner')) !!}</li>
@stop

@section('content')

    {!! Form::model($banner, ['route' => ['admin.banners.update', $banner->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control name-has-url', 'placeholder' => trans('strings.name')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('url', trans('validation.attributes.slug'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => trans('strings.slug')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('title' , trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="form-input col-md-4">
                {!! Form::select('courses[]', [''=>''] + $courses->lists('title', 'id')->all(), $banner->course_id, ['class' => 'form-control select2', 'placeholder' => trans('strings.course') ])  !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('title' , trans('strings.exam'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="form-input col-md-4">
                {!! Form::select('exams[]', [''=>''] + $exams->lists('title', 'id')->all(), $banner->package_id, ['class' => 'form-control select2', 'placeholder' => trans('strings.exam') ])  !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! $banner->img_html['size200'] !!}
                <input type="file" name="img"/>
            </div><!-- /.col -->
        </div>
        <div class="form-group">
            {!! Form::label('order', trans('strings.order'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-2">
                {!! Form::text('order', null, ['class' => 'form-control', 'placeholder' => trans('strings.order')]) !!}
            </div>
        </div><!--form control-->
        <div class="form-group">
             {!! Form::label('carousel', trans('strings.carousel'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-md-6">
                {!!  Form::checkbox('carousel')  !!}
            </div>
        </div>
        <div class="form-group">
             {!! Form::label('is_active', trans('strings.is_active'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-md-6">
                {!!  Form::checkbox('is_active')  !!}
            </div>
        </div>

        <div class="pull-left">
            <a href="{{route('admin.banners.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop