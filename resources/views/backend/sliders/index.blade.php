@extends ('backend.layouts.master')

@section ('title', trans('menus.sliders'))



@section('page-header')
    <h1>
        {{ trans('menus.sliders') }}
        <small>{{ trans('menus.all_sliders') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.sliders.index', trans('menus.sliders')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.sliders.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_slider') }}
        </a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.sliders.name') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sliders as $slider)
            <tr>
                <td>{!! $slider->name !!}</td>
                <td>{!! $slider->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $sliders->total() !!} {{ trans('crud.sliders.total') }}
    </div>

    <div class="pull-right">
        {!! $sliders->render() !!}
    </div>

    <div class="clearfix"></div>
@stop