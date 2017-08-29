@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        {{ trans('menus.userteacher_management') }}
        <small>{{ trans('menus.active_userteachers') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
@stop

@section('content')
    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.userteachers.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_userteachers') }}
        </a>
    </div>
    <div class="clearfix"></div>


    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.userteachers.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_UserTeacherController_name',  trans('strings.name'), ['class' => 'col-md-2 control-label']) !!}
               <div class="col-md-10">
                {!! Form::text('f_UserTeacherController_name', $userteachercontrollername, ['class' => 'form-control']  ) !!}
               </div>
            </div>
            <br>
            <div class="row">
                {!! Form::label('f_UserTeacherController_desactived', trans('strings.desactived'), ['style' => 'padding-top: 0', 'class' => 'col-md-2 control-label']) !!}

                <div class="col-md-6">
                    {!!  Form::checkbox('f_UserTeacherController_desactived', '1', $userteachercontrollerconfirmed === '1' ? 'unchecked' : "")  !!} 
                </div>
            </div>
            <br>
            <div class="row">
                <label class="col-md-2 control-label">{{ trans('validation.attributes.export_to_csv') }}</label> 
                <div class="col-md-2">
                    <div>
                        <div class="sw-green create-permissions-switch">
                            <div class="onoffswitch">
                                <input type="checkbox" value="1" name="f_UserTeacherController_export" class="toggleBtn onoffswitch-checkbox" id="export_to_csv" >
                                <label for="export_to_csv" class="onoffswitch-label">
                                    <div class="onoffswitch-inner"></div>
                                    <div class="onoffswitch-switch"></div>
                                </label>
                            </div>
                        </div><!--green checkbox-->
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
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
            @foreach ($userteachers as $user)
                <tr>
                    <td>{!! $user->name !!}</td>
                    <td>{!! link_to("mailto:".$user->email, $user->email) !!}</td>
                    <td>{!! $user->confirmed_label !!}</td>
                    <td class="visible-lg">{!! format_datebr($user->created_at) !!}</td>
                    <td>{!! $user->teacheraction_buttons !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $userteachers->total() !!} {{ trans('crud.userteachers.total') }}
    </div>

    <div class="pull-right">
        {!! $userteachers->render() !!}
    </div>

    <div class="clearfix"></div>
@stop