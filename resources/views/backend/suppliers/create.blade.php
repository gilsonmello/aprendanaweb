@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section ('before-styles-end')
{!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
<h1>
    {{ trans('menus.suppliers.management') }}
    <small>{{ trans('menus.suppliers.create') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li>
    <a href="{!!route('backend.dashboard')!!}">
        <i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}
    </a>
</li>
<li>
    {!! link_to_route('admin.suppliers.index', trans('menus.suppliers.suppliers')) !!}
</li>
<li class="active">
    {!! trans('strings.create_supplier') !!}
</li>
@stop

@section('content')

{!! Form::open(['route' => 'admin.suppliers.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}

<div class="form-group">
    {!! Form::label('company_name', trans('validation.attributes.company_name'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => trans('strings.company_name')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('contact', trans('validation.attributes.contact'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('contact', null, ['class' => 'form-control', 'placeholder' => trans('strings.contact')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('fone', trans('validation.attributes.fone'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('fone', null, ['class' => 'form-control cel', 'placeholder' => trans('strings.fone')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('city',  trans('validation.attributes.city'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('city_id', ['' => ''] + $cities->lists('name', 'id')->all(), null, ['class' => 'select2']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('city',  trans('validation.attributes.state'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('state_id', ['' => ''] + $states->lists('name', 'id')->all(), null, ['class' => 'select2']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('country',  trans('validation.attributes.country'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('country_id', ['' => ''] + $countries->lists('name', 'id')->all(), null, ['class' => 'select2']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label(null, '&nbsp;', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="pull-left">
            <a href="{{route('admin.suppliers.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>
        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
    </div>
</div>
<div class="clearfix"></div>

{!! Form::close() !!}
@stop