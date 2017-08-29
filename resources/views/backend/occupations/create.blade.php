@extends ('backend.layouts.master')

@section ('title', trans('menus.occupation_management') . ' | ' . trans('menus.create_occupation'))

@section('page-header')
    <h1>
        {{ trans('menus.occupation_management') }}
        <small>{{ trans('menus.create_occupation') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.occupations.index', trans('menus.occupation')) !!}</li>
    <li class="active">{!! link_to_route('admin.occupations.create', trans('menus.create_occupation')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.occupations.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('description', trans('validation.attributes.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
            </div>

        </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.occupations.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop