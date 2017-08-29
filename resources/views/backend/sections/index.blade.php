@extends ('backend.layouts.master')

@section ('title', trans('menus.sections'))

@section('page-header')
    <h1>
        {{ trans('menus.sections') }}
        <small>{{ trans('menus.all_sections') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.sections.index', trans('menus.sections')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.sections.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_section') }}
        </a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.sections.name') }}</th>
            <th>{{ trans('strings.sequence') }}</th>
            <th>{{ trans('strings.active') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sections as $section)
            <tr>
                <td>{!! $section->name !!}</td>
                <td>{!! $section->sequence !!}</td>
                <td>{!! $section->is_active_label !!}</td>
                <td>{!! $section->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $sections->total() !!} {{ trans('crud.sections.total') }}
    </div>

    <div class="pull-right">
        {!! $sections->render() !!}
    </div>

    <div class="clearfix"></div>
@stop