@extends ('backend.layouts.master')

@section ('title', trans('menus.newsletters'))

@section('page-header')
    <h1>
        {{ trans('menus.newsletters') }}
        <small>{{ trans('menus.all_newsletters') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.newsletters.index', trans('menus.newsletters')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.newsletters.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_newsletter') }}
        </a>
        <a href="{{route('admin.newsletters.generate')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.generate_newsletter') }}
        </a>
    </div>

    <div class="clearfix"></div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Filtro</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    {!! Form::open(array('route' => array('admin.newsletters.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
    <div class="box-body">
        <div class="row">
        {!! Form::hidden('f_submit', '1'  ) !!}
        {!! Form::label('f_NewsletterController_name',  trans('strings.name_or_email'), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
        {!! Form::text('f_NewsletterController_name', $newslettercontrollername, ['class' => 'form-control']  ) !!}
        </div>
        </div>
        <hr>
        <div class="row">
                {!! Form::label('f_NewsletterController_campaign_id', trans('strings.campaign'), ['class' => 'control-label col-md-2']) !!}
            
            <div class="col-md-7">
                {!! Form::select('f_NewsletterController_campaign_id', ['' => ''] + $campaigns->lists('name', 'id')->all(), $newslettercontrollercampaignid, ['class' => 'select2']) !!}
            </div>
        </div>
        <hr/>
    </div>
    <div class="box-footer">
        {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
    </div>
    {!! Form::close() !!}
</div>
    
    
    
    
    
    


    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.newsletters.name') }}</th>
            <th>{{ trans('crud.newsletters.email') }}</th>
            <th>{{ trans('crud.newsletters.campaing') }}</th>
            <th>{{ trans('crud.newsletters.created_at') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($newsletters as $newsletter)
            <tr>
                <td>{!! $newsletter->name !!}</td>
                <td>{!! $newsletter->email !!}</td>
                <td>{!! (isset($newsletter->campaign)) ? $newsletter->campaign->name : "" !!}</td>
                <td>{!! format_datebr( $newsletter->created_at ) !!}</td>
                <td>{!! $newsletter->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $newsletters->total() !!} {{ trans('crud.newsletters.total') }}
    </div>

    <div class="pull-right">
        {!! $newsletters->render() !!}
    </div>

    <div class="clearfix"></div>
@stop