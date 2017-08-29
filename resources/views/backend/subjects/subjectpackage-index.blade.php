@extends ('backend.layouts.master')

@section ('title', trans('menus.subjectpackages'))



@section('page-header')
    <h1>
        {{ trans('menus.subjectpackages') }}
        <small>{{ trans('menus.all_subjectpackages') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.subjectpackages.index', trans('menus.subjectpackages')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.subjectpackages.addindex')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.add_package') }}
        </a>
        <a href="{{route('admin.subjects.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('strings.course') }}</th>
            <th>{{ trans('strings.exam') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($subjectpackages as $subjectpackage)
            <tr>
                <td>{!! ($subjectpackage->package != null ? $subjectpackage->package->title : '') !!}</td>
                <td>{!! ($subjectpackage->exam != null ? $subjectpackage->exam->title : '') !!}</td>
                <td>{!! $subjectpackage->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $subjectpackages->count() !!} {{ trans('crud.subjectpackages.total') }}
    </div>

    <div class="clearfix"></div>


@stop