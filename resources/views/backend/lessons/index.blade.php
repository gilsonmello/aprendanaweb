@extends ('backend.layouts.master')

@section ('title', trans('menus.lessons'))



@section('page-header')
    <h1>
        {{ trans('menus.lessons') }}
        <small>{{ trans('menus.all_lessons') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.lessons.index', trans('menus.lessons')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.lessons.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_lesson') }}
        </a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.lessons.img') }}</th>
            <th>{{ trans('crud.lessons.title') }}</th>
            <th>{{ trans('crud.lessons.price') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($lessons as $lesson)
            <tr>
                <td>{!! $lesson->featured_img_html['square100'] !!}</td>
                <td>{!! $lesson->title !!}</td>
                <td>{!! $lesson->price !!}</td>
                <td>{!! $lesson->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $lessons->total() !!} {{ trans('crud.lessons.total') }}
    </div>

    <div class="pull-right">
        {!! $lessons->render() !!}
    </div>

    <div class="clearfix"></div>
@stop