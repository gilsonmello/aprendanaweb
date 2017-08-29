@extends ('backend.layouts.master')

@section ('title', trans('menus.packageteachers'))



@section('page-header')
    <h1>
        {{ trans('menus.packageteachers') }}
        <small>{{ trans('menus.all_packageteachers') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.packageteachers.index', trans('menus.packageteachers')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.packageteachers.addindex')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.add_teacher') }}
        </a>
        <a href="{{route('admin.packages.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.packageteachers.title') }}</th>
            <th>%</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($packageteachers as $packageteacher)
            <tr>
                <td>{!! ($packageteacher->teacher != null ? $packageteacher->teacher->name : '') !!}</td>
                <td>{!!  number_format($packageteacher->percentage, 2, ',', '.' ) !!}</td>
                <td>{!! $packageteacher->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $packageteachers->count() !!} {{ trans('crud.packageteachers.total') }}
    </div>


@stop