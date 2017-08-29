@extends ('backend.layouts.master')

@section ('title', trans('menus.studentgroup_management') . ' | ' . trans('menus.create_studentgroup'))

@section('page-header')
    <h1>
        {{ trans('menus.studentgroup_management') }}
        <small>{{ trans('menus.create_studentgroup') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.studentgroups.index', trans('menus.studentgroup')) !!}</li>
    <li class="active">{!! link_to_route('admin.studentgroups.create', trans('menus.create_studentgroup')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.studentgroups.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('partner_id', trans('strings.partner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('partner_id', $partners->lists("name","id"), null, ['class' => 'form-control']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('name', trans('strings.name'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
        </div>

    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.studentgroups.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop