@extends ('backend.layouts.master')

@section ('name', trans('menus.workshopcriterias'))



@section('page-header')
    <h1>
        {{ trans('menus.workshopcriterias') }}
        <small>{{ trans('menus.all_workshopcriterias') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.workshopcriterias.index', trans('menus.workshopcriterias')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.workshopcriterias.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_workshopcriteria') }}
        </a>
        <a href="{{route('admin.workshops.edit', [$workshop])}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>

    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="70%">{{ trans('crud.workshopcriterias.name') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($workshopcriterias as $workshopcriteria)
            <tr>
                <td>{!! $workshopcriteria->description !!}</td>
                <td>{!! $workshopcriteria->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $workshopcriterias->total() !!} {{ trans('crud.workshopcriterias.total') }}
    </div>

    <div class="pull-right">
        {!! $workshopcriterias->render() !!}
    </div>

    <div class="clearfix"></div>
@stop