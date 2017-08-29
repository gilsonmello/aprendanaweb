
@extends ('backend.layouts.master')

@section ('title', trans('menus.studentgroup_management') . ' | ' . trans('menus.edit_studentgroup'))

@section('page-header')
    <h1>
        {{ trans('menus.studentgroups') }}
        <small>{{ trans('menus.edit_studentgroup') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.studentgroups.index', trans('menus.studentgroups')) !!}</li>
    <li class="active">{!! link_to_route('admin.studentgroups.create', trans('menus.edit_studentgroup')) !!}</li>
@stop

@section('content')

    {!! Form::model($studentgroup, ['route' => ['admin.studentgroups.update', $studentgroup->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('partner_id', trans('strings.partner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('partner_id', $studentgroup->partner->name, ['class' => 'form-control','disabled']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('name', trans('strings.name'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
        </div>

    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.studentgroups.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop