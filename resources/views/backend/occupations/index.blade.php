@extends ('backend.layouts.master')

@section ('name', trans('menus.occupations'))



@section('page-header')
    <h1>
        {{ trans('menus.occupations') }}
        <small>{{ trans('menus.all_occupations') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.occupations.index', trans('menus.occupations')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.occupations.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_occupation') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-description">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.occupations.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_OccupationController_description',  trans('strings.description'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_OccupationController_description', $occupationcontrollerdescription, ['class' => 'form-control']  ) !!}
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
            <th width="70%">{{ trans('crud.occupations.description') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($occupations as $occupation)
            <tr>
                <td>{!! $occupation->description !!}</td>
                <td>{!! $occupation->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $occupations->total() !!} {{ trans('crud.occupations.total') }}
    </div>

    <div class="pull-right">
        {!! $occupations->render() !!}
    </div>

    <div class="clearfix"></div>
@stop