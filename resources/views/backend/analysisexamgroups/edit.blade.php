
@extends ('backend.layouts.master')

@section ('title', trans('menus.analysisexamgroup_management') . ' | ' . trans('menus.edit_analysisexamgroup'))

@section('page-header')
    <h1>
        {{ trans('menus.analysisexamgroups') }}
        <small>{{ trans('menus.edit_analysisexamgroup') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.analysisexamgroups.index', trans('menus.analysisexamgroups')) !!}</li>
    <li class="active">{!! link_to_route('admin.analysisexamgroups.create', trans('menus.edit_analysisexamgroup')) !!}</li>
@stop

@section('content')

    {!! Form::model($analysisexamgroup, ['route' => ['admin.analysisexamgroups.update', $analysisexamgroup->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', $analysisexamgroup->title, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->


    <div class="pull-left">
            <a href="{{route('admin.analysisexamgroups.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop