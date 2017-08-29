@extends ('backend.layouts.master')

@section ('name', trans('menus.workshoptutors'))



@section('page-header')
    <h1>
        {{ trans('menus.workshoptutors') }}
        <small>{{ trans('menus.all_workshoptutors') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.workshoptutors.index', trans('menus.workshoptutors')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.workshoptutors.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_workshoptutor') }}
        </a>
        <a href="{{route('admin.workshops.edit', [$workshop])}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>

    </div>

    <div class="clearfix"></div>


    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="70%">{{ trans('crud.workshoptutors.tutor') }}</th>
            <th width="70%">{{ trans('crud.workshoptutors.criteria') }}</th>
            <th width="70%">{{ trans('crud.workshoptutors.position') }}</th>
            <th width="70%">{{ trans('crud.workshoptutors.max_students') }}</th>
            <th width="70%">{{ trans('crud.workshoptutors.num_students') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($workshoptutors as $workshoptutor)
            <tr>
                <td>{!! $workshoptutor->tutor->name !!}</td>
                <td>{!! $workshoptutor->criteria->description !!}</td>
                <td>{!! $workshoptutor->position !!}</td>
                <td>{!! $workshoptutor->max_students !!}</td>
                <td>{!! $workshoptutor->num_students !!}</td>
                <td>{!! $workshoptutor->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $workshoptutors->total() !!} {{ trans('crud.workshoptutors.total') }}
    </div>

    <div class="pull-right">
        {!! $workshoptutors->render() !!}
    </div>

    <div class="clearfix"></div>
@stop