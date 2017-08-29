
@extends ('backend.layouts.master')

@section ('title', trans('menus.advertisingpartner_management') . ' | ' . trans('menus.edit_advertisingpartner'))

@section('page-header')
    <h1>
        {{ trans('menus.advertisingpartners') }}
        <small>{{ trans('menus.edit_advertisingpartner') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.advertisingpartners.index', trans('menus.advertisingpartners')) !!}</li>
    <li class="active">{!! link_to_route('admin.advertisingpartners.create', trans('menus.edit_advertisingpartner')) !!}</li>
@stop

@section('content')

    {!! Form::model($advertisingpartner, ['route' => ['admin.advertisingpartners.update', $advertisingpartner->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

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
        {!! Form::label('source', trans('strings.source_advertisingpartner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('source', null, ['class' => 'form-control', 'placeholder' => trans('strings.source_advertisingpartner')]) !!}
        </div>

    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.advertisingpartners.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop