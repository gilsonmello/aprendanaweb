@extends ('backend.layouts.master')

@section ('name', trans('menus.workshopactivitys'))



@section('page-header')
    <h1>
        {{ trans('menus.workshopactivitys') }}
        <small>{{ trans('menus.all_workshopactivitys') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.workshopactivitys.index', trans('menus.workshopactivitys')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.workshopactivitys.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_workshopactivity') }}
        </a>
        <a href="{{route('admin.workshops.edit', [$workshop])}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>

    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.workshopactivitys.name') }}</th>
            <th>{{ trans('strings.available_date') }}</th>
            <th>{{ trans('strings.submit_deadline_date') }}</th>
            <th>{{ trans('strings.evaluation_deadline_date') }}</th>
            <th>{{ trans('strings.personal_evaluation') }}</th>

            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($workshopactivitys as $workshopactivity)
            <tr>
                <td>{!! $workshopactivity->description !!}</td>
                <td>{!! $workshopactivity->available_date !!}</td>
                <td>{!! $workshopactivity->submit_deadline_date !!}</td>
                <td>{!! $workshopactivity->evaluation_deadline_date !!}</td>
                <td>{!! $workshopactivity->personal_evaluation == 1 ? "Sim" : "" !!}</td>
                <td>{!! $workshopactivity->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $workshopactivitys->total() !!} {{ trans('crud.workshopactivitys.total') }}
    </div>

    <div class="pull-right">
        {!! $workshopactivitys->render() !!}
    </div>

    <div class="clearfix"></div>
@stop