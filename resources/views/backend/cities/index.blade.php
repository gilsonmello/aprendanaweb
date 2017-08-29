@extends ('backend.layouts.master')

@section ('title', trans('menus.cities'))

@section('page-header')
    <h1>
        {{ trans('menus.cities') }}
        <small>{{ trans('menus.all_cities') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.cities.index', trans('menus.cities')) !!}</li>
@stop

@section('content')


    {!! Form::open(array('route' => array('admin.cities.index'), 'method' => 'get'))  !!}
    {!! Form::hidden('f_submit', '1'  ) !!}
    {!! Form::label('f_CityController_name',  trans('strings.name_or_email')) !!}
    {!! Form::text('f_CityController_name', $citycontrollername  ) !!}
    {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
    {!! Form::close() !!}
    
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.cities.id') }}</th>
            <th>{{ trans('crud.cities.name') }}</th>
            <th>{{ trans('crud.cities.state') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cities as $city)
            <tr>
                <td>{!! $city->id !!}</td>
                <td>{!! $city->name !!}</td>
                <td>{!! $city->state->name !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $cities->total() !!} {{ trans('crud.cities.total') }}
    </div>

    <div class="pull-right">
        {!! $cities->render() !!}
    </div>

    <div class="clearfix"></div>
@stop