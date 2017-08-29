@extends ('backend.layouts.master')

@section ('name', trans('menus.partners'))



@section('page-header')
    <h1>
        {{ trans('menus.partners') }}
        <small>{{ trans('menus.all_partners') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.partners.index', trans('menus.partners')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.partners.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_partner') }}
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
        {!! Form::open(array('route' => array('admin.partners.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_PartnerController_name',  trans('strings.name'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_PartnerController_name', $partnercontrollername, ['class' => 'form-control']  ) !!}
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
            <th width="70%">{{ trans('crud.partners.name') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($partners as $partner)
            <tr>
                <td>{!! $partner->name !!}</td>
                <td>{!! $partner->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $partners->total() !!} {{ trans('crud.partners.total') }}
    </div>

    <div class="pull-right">
        {!! $partners->render() !!}
    </div>

    <div class="clearfix"></div>
@stop