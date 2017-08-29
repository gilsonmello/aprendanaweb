@extends ('backend.layouts.master')

@section ('title', trans('menus.products.products'))

@section('page-header')
<h1>
    {{ trans('menus.products.management') }}
    <small>{{ trans('menus.products.all') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! trans('menus.products.products') !!}</li>
@stop

@section('content')

<div class="pull-right" style="margin-bottom:10px">
    <a href="{{route('admin.products.create')}}" class="btn btn-primary btn-xs">
        {{ trans('menus.products.create') }}
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
        @foreach ($products as $value)
        <tr>
            <td>{!! $value->title !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pull-left">
    {!! $products->total() !!} {{ trans('menus.products.total') }}
</div>

<div class="pull-right">
    {!! $products->render() !!}
</div>

<div class="clearfix"></div>
@stop