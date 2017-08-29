@extends ('backend.layouts.master')

@section ('title', trans('menus.groups'))



@section('page-header')
    <h1>
        {{ trans('menus.groups') }}
        <small>{{ trans('menus.all_groups') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.groups.index', trans('menus.groups')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.groups.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_group') }}
        </a>
        <a href="{{route('admin.exams.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.groups.title') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($groups as $group)
            <tr>
                <td>{!! $group->title !!}</td>
                <td>{!! $group->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $groups->total() !!} {{ trans('crud.groups.total') }}
    </div>

    <div class="pull-right">
        {!! $groups->render() !!}
    </div>

    <div class="clearfix"></div>
@stop