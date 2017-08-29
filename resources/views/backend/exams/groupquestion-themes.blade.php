@extends ('backend.layouts.master')

@section ('title', trans('menus.groupquestions'))



@section('page-header')
    <h1>
        {{ trans('menus.groupquestions') }}
        <small>{{ trans('menus.all_groupquestions') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.groupquestions.index', trans('menus.groupquestions')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.groupquestions.subthemes', $group)}}" class="btn btn-primary btn-xs">
            {{ trans('strings.subtheme') }}
        </a>
        <a href="{{route('admin.groupquestions.originals', $group)}}" class="btn btn-primary btn-xs">
            {{ trans('strings.origin') }}
        </a>
        <a href="{{route('admin.groups.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover" style="width: 60% !important">
        <thead>
        <tr>
            <th  width="60%">{{ trans('strings.theme') }}</th>
            <th  width="20%" class="text-right">{{ trans('strings.quantity_questions') }}</th>
            <th  width="20%" class="text-right">{{ trans('strings.percentage') }}</th>
        </tr>
        </thead>
        <tbody>

            @foreach ($themes as $theme)
                <tr>
                    <td><strong>[{!! $theme->discipline !!}]</strong> {!! $theme->name !!}</td>
                    <td class="text-right">{!! $theme->questions !!}</td>
                    <td class="text-right">{!! number_format( $theme->questions / $total * 100, 2, ',', '.') !!}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>TOTAL</strong></td>
                <td class="text-right">{!! $total !!}</td>
                <td class="text-right"></td>
            </tr>
        </tbody>
    </table>

    <div class="pull-left">
        {!! $themes->count() !!} {{ trans('crud.themes.total') }}
    </div>

    <div class="clearfix"></div>


@stop