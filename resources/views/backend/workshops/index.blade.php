@extends ('backend.layouts.master')

@section ('name', trans('menus.workshops'))



@section('page-header')
    <h1>
        {{ trans('menus.workshops') }}
        <small>{{ trans('menus.all_workshops') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.workshops.index', trans('menus.workshops')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.workshops.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_workshop') }}
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
        {!! Form::open(array('route' => array('admin.workshops.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_WorkshopController_description',  trans('strings.description'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_WorkshopController_description', $workshopcontrollerdescription, ['class' => 'form-control']  ) !!}
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
            <th width="30%">{{ trans('strings.course') }}</th>
            <th width="40%">{{ trans('crud.workshops.description') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($workshops as $workshop)
            <tr>
                <td>{!! $workshop->course->title !!}</td>
                <td>{!! $workshop->description !!}</td>
                <td>{!! $workshop->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $workshops->total() !!} {{ trans('crud.workshops.total') }}
    </div>

    <div class="pull-right">
        {!! $workshops->render() !!}
    </div>

    <div class="clearfix"></div>
@stop