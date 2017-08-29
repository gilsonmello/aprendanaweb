@extends ('backend.layouts.master')

@section ('title', trans('menus.newsletter_management') . ' | ' . trans('menus.create_newsletter'))

@section('page-header')
    <h1>
        {{ trans('menus.newsletter_management') }}
        <small>{{ trans('menus.create_newsletter') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.newsletters.index', trans('menus.newsletters')) !!}</li>
    <li class="active">{!! link_to_route('admin.newsletters.create', trans('menus.create_newsletter')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.newsletters.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('Email')]) !!}
            </div>
        </div><!--form control-->


        <div class="pull-left">
            <a href="{{route('admin.newsletters.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop