@extends ('backend.layouts.master')

@section ('title', trans('menus.suppliers.suppliers'))

@section('page-header')
<h1>
    {{ trans('menus.suppliers.management') }}
    <small>{{ trans('menus.suppliers.all') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! trans('menus.suppliers.suppliers') !!}</li>
@stop

@section('content')

<div class="pull-right" style="margin-bottom:10px">
    <a href="{{route('admin.suppliers.create')}}" class="btn btn-primary btn-xs">
        {{ trans('menus.suppliers.create') }}
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
    {!! Form::open(array('route' => array('admin.news.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
    <div class="box-body">
        <div class="row">
            {!! Form::hidden('f_submit', '1'  ) !!}
            {!! Form::label('f_NewsController_title',  trans('strings.title'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-10">
                {{-- {!! Form::text('f_NewsController_title', $newscontrollertitle, ['class' => 'form-control']  ) !!} --}}
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
            <th>{{ trans('strings.company_name') }}</th>
            <th>{{ trans('strings.contact') }}</th>
            <th class="text-center">{{ trans('strings.fone') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($suppliers as $value)
        <tr>
            <td>{!! $value->company_name !!}</td>
            <td>{!! $value->contact !!}</td>
            <td class="text-center">{!! $value->fone !!}</td>
            <td>{!! $value->action_buttons !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pull-left">
    {!! $suppliers->total() !!} {{ trans('menus.suppliers.total') }}
</div>

<div class="pull-right">
    {!! $suppliers->render() !!}
</div>

<div class="clearfix"></div>
@stop