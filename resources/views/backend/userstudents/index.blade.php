@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        {{ trans('menus.userstudent_management') }}
        <small>{{ trans('menus.active_userstudents') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
@stop

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Filtro</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    {!! Form::open(array('route' => array('admin.userstudents.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
    <div class="box-body">
        <div class="row">
            {!! Form::hidden('f_submit', '1'  ) !!}
            {!! Form::label('f_UserStudentController_name',  trans('strings.name_or_email'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-10">
            {!! Form::text('f_UserStudentController_name', $userstudentcontrollername,['class' => 'form-control']  ) !!}
            </div>
        </div>       
    </div>
    <div class="box-footer">
        {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>


    

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.users.name') }}</th>
            <th>{{ trans('crud.users.email') }}</th>
            <th>{{ trans('crud.users.confirmed') }}</th>
            <th class="visible-lg">{{ trans('crud.users.created') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($userstudents as $user)
                <tr>
                    <td>{!! $user->name !!}</td>
                    <td>{!! link_to("mailto:".$user->email, $user->email) !!}</td>
                    <td>{!! $user->confirmed_label !!}</td>
                    <td class="visible-lg">{!! format_datebr($user->created_at) !!}</td>
                    <td>{!! $user->studentaction_buttons !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $userstudents->total() !!} {{ trans('crud.userstudents.total') }}
    </div>

    <div class="pull-right">
        {!! $userstudents->render() !!}
    </div>

    <div class="clearfix"></div>
@stop