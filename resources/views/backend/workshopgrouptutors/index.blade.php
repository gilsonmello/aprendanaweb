@extends ('backend.layouts.master')

@section ('name', trans('menus.workshopgrouptutors'))



@section('page-header')
    <h1>
        {{ trans('menus.workshopgrouptutors') }}
        <small>{{ trans('menus.all_workshopgrouptutors') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.workshopgrouptutors.index', trans('menus.workshopgrouptutors')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.workshopgrouptutors.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_workshopgrouptutor') }}
        </a>
        <a href="{{route('admin.workshopevaluationgroups.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>

    </div>

    <div class="clearfix"></div>


    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="70%">{{ trans('crud.workshopgrouptutors.tutor') }}</th>
            <th width="70%">{{ trans('crud.workshopgrouptutors.activity') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($workshopgrouptutors as $workshopgrouptutor)
            <tr>
                <td>{!! $workshopgrouptutor->tutor->name !!}</td>
                <td>{!! $workshopgrouptutor->activity->description !!}</td>
                <td>{!! $workshopgrouptutor->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $workshopgrouptutors->total() !!} {{ trans('crud.workshopgrouptutors.total') }}
    </div>

    <div class="pull-right">
        {!! $workshopgrouptutors->render() !!}
    </div>

    <div class="clearfix"></div>
@stop