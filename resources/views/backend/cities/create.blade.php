@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
        <small>{{ trans('menus.create_user') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.cities.index', trans('menus.cities')) !!}</li>
    <li class="active">{!! link_to_route('admin.cities.create', trans('menus.create_city')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.cities.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('id', trans('strings.id'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('id', null, ['class' => 'form-control', 'placeholder' => trans('strings.id')]) !!}
        </div>
    </div><!--form control-->

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('id_state', trans('strings.state'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('id_state', $states) !!}
            </div>
        </div><!--form control-->


        <div class="pull-left">
            <a href="{{route('admin.cities.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop