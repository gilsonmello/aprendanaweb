@extends ('backend.layouts.master')

@section ('title', trans('menus.modules'))



@section('page-header')
    <h1>
        {{ trans('menus.modules') }}
        <small>{{ trans('menus.all_modules') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.modules.index', trans('menus.modules')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.modules.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_module') }}
        </a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.modules.img') }}</th>
            <th>{{ trans('crud.modules.name') }}</th>
            <th>{{ trans('crud.modules.price') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($modules as $module)
            <tr>
                <td>{!! $module->featured_img_html['square100'] !!}</td>
                <td>{!! $module->name !!}</td>
                <td>{!! $module->price !!}</td>
                <td>{!! $module->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $modules->total() !!} {{ trans('crud.modules.total') }}
    </div>

    <div class="pull-right">
        {!! $modules->render() !!}
    </div>

    <div class="clearfix"></div>
@stop