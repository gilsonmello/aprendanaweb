@extends ('backend.layouts.master')

@section ('title', trans('menus.sectors'))



@section('page-header')
    <h1>
        {{ trans('menus.sectors') }}
        <small>{{ trans('menus.all_sectors') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.sectors.index', trans('menus.sectors')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.sectors.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_sector') }}
        </a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.sectors.name') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sectors as $sector)
            <tr>
                <td>{!! $sector->name !!}</td>
                <td>{!! $sector->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $sectors->total() !!} {{ trans('crud.sectors.total') }}
    </div>

    <div class="pull-right">
        {!! $sectors->render() !!}
    </div>

    <div class="clearfix"></div>
@stop