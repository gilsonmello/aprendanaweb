@extends ('backend.layouts.master')

@section ('title', trans('menus.tags'))

@section('page-header')
    <h1>
        {{ trans('menus.tags') }}
        <small>{{ trans('menus.all_tags') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.tags.index', trans('menus.tags')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.tags.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_tag') }}
        </a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.tags.name') }}</th>
            <th>{{ trans('crud.tags.description') }}</th>
            <th>{{ trans('crud.tags.active_at') }}</th>
            <th>{{ trans('crud.tags.user_moderator') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tags as $tag)
            <tr>
                <td>{!! $tag->name !!}</td>
                <td>{!! $tag->description !!}</td>
                <td>{!! format_datebr($tag->active_at) !!}</td>
                <td>{!! $tag->userModeratorName !!}</td>
                <td>{!! $tag->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $tags->total() !!} {{ trans('crud.tags.total') }}
    </div>

    <div class="pull-right">
        {!! $tags->render() !!}
    </div>

    <div class="clearfix"></div>
@stop