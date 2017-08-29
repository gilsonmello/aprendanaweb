@extends ('backend.layouts.master')

@section ('name', trans('menus.analysisexams'))



@section('page-header')
    <h1>
        {{ trans('menus.analysisexams') }}
        <small>{{ trans('menus.all_analysisexams') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.analysisexams.index', trans('menus.analysisexams')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.analysisexams.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_analysisexam') }}
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
        {!! Form::open(array('route' => array('admin.analysisexams.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_AnalysisExamController_title',  trans('strings.title'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_AnalysisExamController_title', $analysisexamcontrollertitle, ['class' => 'form-control']  ) !!}
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
            <th width="70%">{{ trans('strings.name') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($analysisexams as $analysisexam)
            <tr>
                <td>{!! $analysisexam->title !!}</td>
                <td>{!! $analysisexam->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $analysisexams->total() !!} {{ trans('crud.analysisexams.total') }}
    </div>

    <div class="pull-right">
        {!! $analysisexams->render() !!}
    </div>

    <div class="clearfix"></div>
@stop