@extends ('backend.layouts.master')

@section ('title', trans('menus.news'))



@section('page-header')
    <h1>
        {{ trans('menus.news') }}
        <small>{{ trans('menus.all_news') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.news.index', trans('menus.news')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.news.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_new') }}
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
                    {!! Form::text('f_NewsController_title', $newscontrollertitle, ['class' => 'form-control']  ) !!}
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
            <th width="70%">{{ trans('crud.news.title') }}</th>
            <th>{{ trans('crud.news.date') }}</th>
            <th class="text-right">{{ trans('crud.news.hits') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($news as $new)
            <tr>
                <td>{!! $new->title !!}</td>
                <td>{!! $new->date !!}</td>
                <td class="text-right">{!! $new->hits !!}</td>
                <td>{!! $new->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $news->total() !!} {{ trans('crud.news.total') }}
    </div>

    <div class="pull-right">
        {!! $news->render() !!}
    </div>

    <div class="clearfix"></div>
@stop