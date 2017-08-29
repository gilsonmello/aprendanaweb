@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
<h1>
    {{ trans('menus.userstudent_management') }}
    <small>{{ trans('menus.active_userstudents') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
@stop

@section('content')
<div class="pull-right" style="margin-bottom:10px">
    <a href="{{route('admin.userstudents.enrollments', $viewcontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.courses') }}</a>
</div>
<br/>
<br/>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th width="400">{{ trans('crud.users.lesson') }}</th>
            <th class="text-right bold" width="60">{{ trans('crud.users.max_view') }}</th>
            <th class="text-right bold" width="60">{{ trans('crud.users.view') }}</th>
            <th class="text-right bold" width="60">{{ trans('crud.users.percentage') }}</th>
            <th  width="120">{{ trans('crud.users.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($views as $view)
        @if ($view->content != null)
        <tr>
            @if ($viewcontrollerenrollment->lesson != null)
            <td>{!! '<b>' .$view->content->lesson->title . '</b> - ' .
                trans('strings.part_lesson') . ' ' .
                '<b>' .$view->content->sequence . '</b> '
                !!}</td>
            @elseif ($viewcontrollerenrollment->module != null)
            <td>{!! '<b>' . $view->content->lesson->module->name . '</b> - ' .
                trans('strings.lesson') . ' ' .
                '<b>' .$view->content->lesson->sequence . '</b> - ' .
                trans('strings.part_lesson') . ' ' .
                '<b>' .$view->content->sequence . '</b> '
                !!}</td>
            @else
            <td>{!! '<b>' . $view->content->lesson->module->course->title . '</b> - ' .
                '<b>' . $view->content->lesson->module->name . '</b> - ' .
                trans('strings.lesson') . ' ' .
                '<b>' .$view->content->lesson->sequence . '</b> - ' .
                trans('strings.part_lesson') . ' ' .
                '<b>' .$view->content->sequence . '</b> '
                !!}</td>
            @endif

            <td class="text-right bold">{!! $view->max_view !!}</td>
            <td class="text-right bold {{ $view->view < $view->max_view ? "green" : "red" }}">
                {!! $view->view !!}
            </td>
            <td class="text-right bold">{!! ($view->view > 0 ? "-" : $view->percent . "%") !!}</td>
            <td>{!! $view->view_button !!} </td>

        </tr>
        @endif
        @endforeach
    </tbody>
</table>
<div class="clearfix"></div>
@stop