@extends ('backend.layouts.master')

@section ('title', trans('menus.myworkshoptutor_management') . ' | ' . trans('menus.create_myworkshoptutor'))

@section('page-header')
    <h1>
        {{ trans('menus.myworkshoptutor_management') }}
        <small>{{ trans('menus.create_myworkshoptutor') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.myworkshoptutors.index', trans('menus.myworkshoptutor')) !!}</li>
    <li class="active">{!! link_to_route('admin.myworkshoptutors.create', trans('menus.create_myworkshoptutor')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.myworkshoptutors.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
            </div>

        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
        </div>
    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.myworkshoptutors.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop