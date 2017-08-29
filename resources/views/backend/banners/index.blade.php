@extends ('backend.layouts.master')

@section ('title', trans('menus.banners'))

@section('page-header')
    <h1>
        {{ trans('menus.banners') }}
        <small>{{ trans('menus.all_banners') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.banners.index', trans('menus.banners')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.banners.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_banner') }}
        </a>
    </div>
    <br><br>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        {!! Form::open(['route' => ['admin.banners'], 'class' => 'form-horizontal', 'method' => 'get'])  !!}
            <div class="box-body">
                {!! Form::hidden('f_submit', '1') !!}
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-1">
                            {!! Form::label('carousel', trans('strings.carousel'), ['class' => 'col-lg-1 control-label']) !!}
                        </div>
                        <div class="col-md-1">
                            {!!  Form::checkbox('carousel', '1', $carousel == '1' ? true : false)  !!}
                        </div>
                        <div class="col-md-1">
                            {!! Form::label('is_active', trans('strings.is_active'), ['class' => 'col-lg-1 control-label']) !!}
                        </div>
                        <div class="col-md-1">
                            {!!  Form::checkbox('is_active', '1', $isactive == '1' ? true : false)  !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <br>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>{{ trans('crud.banners.name') }}</th>
                <th>{{ trans('strings.slug') }}</th>
                <th>{{ trans('strings.order') }}</th>
                <th>{{ trans('strings.carousel') }}</th>
                <th width="100">{{ trans('crud.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $banner)
                <tr>
                    <td>{!! $banner->name !!}</td>
                    <td>{!! $banner->url !!}</td>
                    <td>{!! $banner->order !!}</td>
                    <td>{!! ($banner->carousel == 1) ? trans("strings.yes") : trans("strings.no")!!}</td>
                    <td>{!! $banner->action_buttons !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $banners->total() !!} {{ trans('crud.banners.total') }}
    </div>

    <div class="pull-right">
        {!! $banners->render() !!}
    </div>

    <div class="clearfix"></div>
@stop