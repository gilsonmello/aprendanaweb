@extends ('backend.layouts.master')


@section ('title', trans('menus.webinars.all_webinar'))

@section('page-header')
    <h1>
        {!!   trans('menus.webinars.webinars') !!}
        <small>{!! trans('menus.webinars.all_webinar') !!}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.webinars.webinars') !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.webinars.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.webinars.webinar_create') }}
        </a>
        {{--<a href="{{route('admin.coupons.import')}}" class="btn btn-primary btn-xs">--}}
            {{--{{ trans('menus.import_coupon') }}--}}
        {{--</a>--}}
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.webinars.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_CouponController_name',  trans('strings.title'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_WebinarController_title', $webinarontrollertitle, ['class' => 'form-control']  ) !!}
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('strings.title') }}</th>
            <th>{{ trans('strings.description') }}</th>
            <th>{{ trans('strings.course') }}</th>
            <th>{{ trans('strings.url') }}</th>
            <th>{{ trans('strings.date') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($webinars as $value)
            <tr>
                <td>{!! $value->title !!}</td>
                <td>{!! $value->description !!}</td>
                <td>{!! $value->course->title !!}</td>
                <td>{!! $value->youtube_live_url !!}</td>
                <td>{!! (isset($value->date)) ? format_br($value->date, 'd/m/Y H:i:s') : "Em breve"!!}</td>
                <td>{!! $value->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $webinars->total() !!} {{ trans('menus.webinars.webinar').'(s)' }}
    </div>

    <div class="pull-right">
        {!! $webinars->render() !!}
    </div>

    <div class="clearfix"></div>

    <div class="modal fade" id="modalUsersCourse" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document" style="width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="groupSubjectLabel" style="color: #08C">Lista de E-mails</h4>
                </div>

                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@stop