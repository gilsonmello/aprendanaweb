
@extends ('backend.layouts.master')

@section ('title', trans('menus.institution_management') . ' | ' . trans('menus.edit_institution'))

@section('page-header')
    <h1>
        {{ trans('menus.institutions') }}
        <small>{{ trans('menus.edit_institution') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.institutions.index', trans('menus.institutions')) !!}</li>
    <li class="active">{!! link_to_route('admin.institutions.create', trans('menus.edit_institution')) !!}</li>
@stop

@section('content')

    {!! Form::model($institution, ['route' => ['admin.institutions.update', $institution->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('nome', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', $institution->name, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('abbreviation', trans('strings.abbreviation'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('abbreviation', null, ['class' => 'form-control', 'placeholder' => trans('strings.abbreviation')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
        </div>
    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.institutions.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop