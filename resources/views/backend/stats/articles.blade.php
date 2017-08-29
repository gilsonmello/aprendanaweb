@extends ('backend.layouts.master')

@section ('title', trans('menus.articles'))



@section('page-header')
    <h1>
        {{ trans('menus.stats') }}
        <small>{{ trans('menus.stats_articles') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.stats.articles', trans('menus.stats_articles')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.stats.coursesrank')}}" class="btn btn-primary btn-xs">{{ trans('menus.stats_coursesrank') }}</a>
        <a href="{{route('admin.stats.coursessales')}}" class="btn btn-primary btn-xs">{{ trans('menus.stats_coursessales') }}</a>
        <a href="{{route('admin.stats.videos')}}" class="btn btn-primary btn-xs">{{ trans('menus.stats_videos') }}</a>
        <a href="{{route('admin.stats.articles')}}" class="btn btn-primary btn-xs">{{ trans('menus.stats_articles') }}</a>
    </div>


    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="80%" >{{ trans('crud.articles.title') }}</th>
            <th width="20%" class="text-right">{{ trans('crud.articles.hits') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($articles as $article)
            <tr>
                <td>{!! $article->title !!}</td>
                <td class="text-right">{!! $article->hits !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <div class="clearfix"></div>
@stop