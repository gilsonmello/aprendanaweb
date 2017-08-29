@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))


@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
        <small>{{ trans('menus.active_users') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
@stop

@section('content')
    @include('backend.access.includes.partials.header-buttons')
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Filtro</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- form start -->
            {!! Form::open(array('route' => array('admin.access.users.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
    {!! Form::hidden('f_submit', '1'  ) !!}
    {!! Form::label('f_UserController_name',  trans('strings.name_or_email'), ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
    {!! Form::text('f_UserController_name', $usercontrollername, ['class' => 'form-control'] ) !!}
    </div>
    {!! Form::label('f_UserController_role',  trans('strings.role'), ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
    {!! Form::select('f_UserController_role', ['' => '','Administrador' => 'Administrador','Professor' => 'Professor','Aluno' => 'Aluno'], $usercontrollerrole, ['class' => 'form-control']) !!}
    </div>
    <div class="clearfix"></div>
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
            <th>{{ trans('crud.users.roles') }}</th>
            <th>{{ trans('crud.users.other_permissions') }}</th>
            <th class="visible-lg">{{ trans('crud.users.created') }}</th>
            <th class="visible-lg">{{ trans('crud.users.last_updated') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{!! $user->name !!}</td>
                    <td>{!! link_to("mailto:".$user->email, $user->email) !!}</td>
                    <td>{!! $user->confirmed_label !!}</td>
                    <td>
                        @if ($user->roles()->count() > 0)
                            @foreach ($user->roles as $role)
                                {!! $role->name !!}<br/>
                            @endforeach
                        @else
                            None
                        @endif
                    </td>
                    <td>
                        @if ($user->permissions()->count() > 0)
                            @foreach ($user->permissions as $perm)
                                {!! $perm->display_name !!}<br/>
                            @endforeach
                        @else
                            None
                        @endif
                    </td>
                    <td class="visible-lg">{!! $user->created_at->diffForHumans() !!}</td>
                    <td class="visible-lg">{!! $user->updated_at->diffForHumans() !!}</td>
                    <td>{!! $user->action_buttons !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $users->total() !!} {{ trans('crud.users.total') }}
    </div>

    <div class="pull-right">
        {!! $users->render() !!}
    </div>

    <div class="clearfix"></div>
@stop