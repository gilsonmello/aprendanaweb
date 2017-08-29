@extends ('backend.layouts.master')

@section ('title', trans('menus.tag_management') . ' | ' . trans('menus.create_tag'))

@section('page-header')
    <h1>
        {{ trans('menus.tag_management') }}
        <small>{{ trans('menus.create_tag') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.tags.index', trans('menus.tags')) !!}</li>
    <li class="active">{!! link_to_route('admin.tags.create', trans('menus.create_tag')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.tags.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('description', trans('validation.attributes.description'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.definition')]) !!}
        </div>
    </div><!--form control-->

        <div class="pull-left">
            <a href="{{route('admin.tags.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop