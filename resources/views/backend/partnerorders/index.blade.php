@extends ('backend.layouts.master')

@section ('name', trans('menus.partnerorders'))



@section('page-header')
    <h1>
        {{ trans('menus.partnerorders') }}
        <small>{{ trans('menus.all_partnerorders') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.partnerorders.index', trans('menus.partnerorders')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.partnerorders.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_partnerorder') }}
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
        {!! Form::open(array('route' => array('admin.partnerorders.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_PartnerController_partner_id',  trans('strings.name'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::select('f_PartnerController_partner_id', [''=>''] + $partners->lists('name', 'id')->all(), $partnerordercontrollerpartnerid, ['class' => 'select2']) !!}
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
            <th width="35%">{{ trans('crud.partnerorders.partner') }}</th>
            <th width="35%">{{ trans('crud.partnerorders.course') }}</th>
            <th width="10%">{{ trans('crud.partnerorders.total_enrollments') }}</th>
            <th width="10%">{{ trans('crud.partnerorders.used_enrollments') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($partnerorders as $partnerorder)
            <tr>
                <td>{!! $partnerorder->partner->name !!}</td>
                <td>{!! $partnerorder->course->title !!}</td>
                <td>{!! $partnerorder->total_enrollments !!}</td>
                <td>{!! $partnerorder->used_enrollments !!}</td>
                <td>{!! $partnerorder->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $partnerorders->total() !!} {{ trans('crud.partnerorders.total') }}
    </div>

    <div class="pull-right">
        {!! $partnerorders->render() !!}
    </div>



    <div class="clearfix"></div>
@stop