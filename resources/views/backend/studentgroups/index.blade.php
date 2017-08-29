@extends ('backend.layouts.master')

@section ('name', trans('menus.studentgroups'))



@section('page-header')
    <h1>
        {{ trans('menus.studentgroups') }}
        <small>{{ trans('menus.all_studentgroups') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.studentgroups.index', trans('menus.studentgroups')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.studentgroups.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_studentgroup') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-name">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.studentgroups.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_PartnerController_partner_id',  trans('strings.partner'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::select('f_PartnerController_partner_id', $partners->lists('name', 'id'), $studentgroupcontrollerpartnerid, ['class' => 'select2']) !!}
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
            <th width="35%">{{ trans('crud.studentgroups.name') }}</th>
            <th width="35%">{{ trans('strings.partner') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($studentgroups as $studentgroup)
            <tr>
                <td>{!! $studentgroup->name !!}</td>
                <td>{!! $studentgroup->partner->name !!}</td>
                <td>{!! $studentgroup->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $studentgroups->total() !!} {{ trans('crud.studentgroups.total') }}
    </div>

    <div class="pull-right">
        {!! $studentgroups->render() !!}
    </div>



    <div class="clearfix"></div>
@stop