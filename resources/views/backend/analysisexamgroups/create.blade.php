@extends ('backend.layouts.master')

@section ('title', trans('menus.analysisexamgroup_management') . ' | ' . trans('menus.create_analysisexamgroup'))

@section('page-header')
    <h1>
        {{ trans('menus.analysisexamgroup_management') }}
        <small>{{ trans('menus.create_analysisexamgroup') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.analysisexamgroups.index', trans('menus.analysisexamgroup')) !!}</li>
    <li class="active">{!! link_to_route('admin.analysisexamgroups.create', trans('menus.create_analysisexamgroup')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.analysisexamgroups.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
            </div>

        </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.analysisexamgroups.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop