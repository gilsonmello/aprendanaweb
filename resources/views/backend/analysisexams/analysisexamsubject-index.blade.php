@extends ('backend.layouts.master')

@section ('title', trans('menus.analysisexamsubjects'))



@section('page-header')
    <h1>
        {{ trans('menus.analysisexamsubjects') }}
        <small>{{ trans('menus.all_analysisexamsubjects') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.analysisexamsubjects.index', trans('menus.analysisexamsubjects')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.analysisexamsubjects.addindex')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.add_analysisexamsubject') }}
        </a>
        <a href="{{route('admin.analysisexams.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('strings.theme') }}</th>
            <th>{{ trans('strings.questions') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($analysisexamsubjects as $analysisexamsubject)
            <tr>
                <td>{!! ($analysisexamsubject->subject != null ? '['. $analysisexamsubject->subject->parent->name . '] - ' . $analysisexamsubject->subject->name : '') !!}</td>
                <td>{!! $analysisexamsubject->count !!}</td>
                <td>{!! $analysisexamsubject->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $analysisexamsubjects->count() !!} {{ trans('crud.analysisexamsubjects.total') }}
    </div>

    <div class="clearfix"></div>


@stop