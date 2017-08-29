@extends ('backend.layouts.master')

@section ('name', trans('menus.workshopevaluationgroups'))



@section('page-header')
    <h1>
        {{ trans('menus.workshopevaluationgroups') }}
        <small>{{ trans('menus.all_workshopevaluationgroups') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.workshopevaluationgroups.index', trans('menus.workshopevaluationgroups')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.workshopevaluationgroups.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_workshopevaluationgroup') }}
        </a>
        <a href="{{route('admin.workshops.edit', [$workshop])}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>

    </div>

    <div class="clearfix"></div>


    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="40%">{{ trans('strings.description') }}</th>
            <th width="15%">{{ trans('crud.workshopevaluationgroups.position') }}</th>
            <th width="15%">{{ trans('crud.workshopevaluationgroups.max_students') }}</th>
            <th width="15%">{{ trans('crud.workshopevaluationgroups.num_students') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($workshopevaluationgroups as $workshopevaluationgroup)
            <tr>
                <td>{!! $workshopevaluationgroup->description !!}</td>
                <td>{!! $workshopevaluationgroup->position !!}</td>
                <td>{!! $workshopevaluationgroup->max_students !!}</td>
                <td>{!! $workshopevaluationgroup->num_students !!}</td>
                <td>{!! $workshopevaluationgroup->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $workshopevaluationgroups->total() !!} {{ trans('crud.workshopevaluationgroups.total') }}
    </div>

    <div class="pull-right">
        {!! $workshopevaluationgroups->render() !!}
    </div>

    <div class="clearfix"></div>
@stop