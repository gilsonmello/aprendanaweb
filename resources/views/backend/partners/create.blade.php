@extends ('backend.layouts.master')

@section ('title', trans('menus.partner_management') . ' | ' . trans('menus.create_partner'))

@section('page-header')
    <h1>
        {{ trans('menus.partner_management') }}
        <small>{{ trans('menus.create_partner') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.partners.index', trans('menus.partner')) !!}</li>
    <li class="active">{!! link_to_route('admin.partners.create', trans('menus.create_partner')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.partners.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
            </div>

        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('contact', trans('strings.contact'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('contact', null, ['class' => 'form-control', 'placeholder' => trans('strings.contact')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('phone', trans('strings.phone'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => trans('strings.phone')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('days_subscribe', trans('crud.partners.days_subscribe'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('days_subscribe', null, ['class' => 'form-control', 'placeholder' => trans('crud.partners.days_subscribe')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('video_quality', trans('strings.video_quality'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('video_quality', '0', true) !!}  {!! trans('strings.auto') !!}
            &nbsp;&nbsp;{!! Form::radio('video_quality', '1') !!} {!! trans('strings.low') !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('image', trans('strings.logo'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="logo"/>
        </div><!-- /.col -->
    </div>


    <div class="pull-left">
            <a href="{{route('admin.partners.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop