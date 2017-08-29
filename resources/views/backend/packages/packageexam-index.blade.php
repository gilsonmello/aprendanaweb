@extends ('backend.layouts.master')

@section ('title', trans('menus.packageexams'))



@section('page-header')
    <h1>
        {{ trans('menus.packageexams') }}
        <small>{{ trans('menus.all_packageexams') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.packageexams.index', trans('menus.packageexams')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.packageexams.addindex')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.add_exam') }}
        </a>
        <a href="{{route('admin.packages.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>

    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.packageexams.title') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($packageexams as $packageexam)
            <tr>
                <td>{!! ($packageexam->exam != null ? $packageexam->exam->title : '') !!}</td>
                <td>{!! $packageexam->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $packageexams->count() !!} {{ trans('crud.packageexams.total') }}
    </div>


@stop