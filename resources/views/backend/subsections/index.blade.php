@extends ('backend.layouts.master')

@section ('title', trans('menus.subsections'))

@section('page-header')
    <h1>
        {{ trans('menus.subsections') }}
        <small>{{ trans('menus.all_subsections') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.subsections.index', trans('menus.subsections')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.subsections.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_subsection') }}
        </a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('strings.section') }}</th>
            <th>{{ trans('crud.subsections.name') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($subsections as $subsection)
            <tr>
                <td>{!! $subsection->section->name !!}</td>
                <td>{!! $subsection->name !!}</td>
                <td>{!! $subsection->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $subsections->total() !!} {{ trans('crud.subsections.total') }}
    </div>

    <div class="pull-right">
        {!! $subsections->render() !!}
    </div>

    <div class="clearfix"></div>
@stop