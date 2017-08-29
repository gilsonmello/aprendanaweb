@extends('backend.layouts.master')

@section('page-header')
    <h1>
        {{ trans('strings.backend.WELCOME') }} {!! auth()->user()->name !!}!
    </h1>
@endsection

@section('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{{ trans('strings.here') }}</li>
@endsection

@section('content')
    @if ((access()->hasPermission('tickets')) && ($tickets->count() > 0))
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('strings.tickets_not_replied') }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('crud.tickets.id') }}</th>
                        <th>{{ trans('crud.tickets.student') }}</th>
                        <th>{{ trans('crud.tickets.sector') }}</th>
                        <th>{{ trans('crud.tickets.message') }}</th>
                        <th>{{ trans('crud.tickets.date_dead_line_reply') }}</th>
                        <th>{{ trans('crud.tickets.updated_at') }}</th>
                        <th>{{ trans('crud.tickets.is_replied') }}</th>
                        <th>{{ trans('crud.tickets.is_finished') }}</th>
                        <th>{{ trans('crud.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{!! $ticket->id !!}</td>
                            <td>{!! ($ticket->userStudent != null ? $ticket->userStudent->name : "") !!}</td>
                            <td>{!! ($ticket->sector != null ? $ticket->sector->name : "") !!}</td>
                            <td width="40%">{!! strlen($ticket->message) < 80 ? $ticket->message : substr($ticket->message, 0, 80) . '...' !!}</td>
                            <td>{!! format_datetimebr($ticket->date_dead_line_reply) !!}</td>
                            <td>{!! format_datetimebr($ticket->updated_at) !!}</td>
                            <td> {!! $ticket->is_replied_label !!}</td>
                            <td> {!! $ticket->is_finished_label !!}</td>
                            <td>{!! $ticket->action_buttons !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!--box box-success-->
    @endif

    @if ((access()->hasPermission('orders')) && ($orders != null) && ($orders->count() > 0))
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('strings.recent_orders') }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="5%">{{ trans('crud.orders.id') }}</th>
                        <th width="23%">{{ trans('crud.orders.student') }}</th>
                        <th width="16%">{{ trans('crud.orders.status') }}</th>
                        <th width="16%">{{ trans('crud.orders.coupon_code') }}</th>
                        <th width="16%">{{ trans('crud.orders.date_registration') }}</th>
                        <th width="16%">{{ trans('crud.orders.date_confirmation') }}</th>
                        <th width="" class="text-right">{{ trans('crud.orders.price') }}</th>
                        <th width="" class="text-right">{{ trans('crud.orders.discount_price') }}</th>
                        <th width="12%">{{ trans('crud.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{!! $order->id !!}</td>
                            <td>{!! $order->student != null ? $order->student->name : '' !!}</td>
                            <td class="bold {{ $order->status_id == 4 ? "green" :  ($order->status_id == 5 ? "red" : "blue" ) }}">
                                {!! $order->status != null ? $order->status->name : '' !!}
                            </td>
                            <td class="bold">
                                {!! $order->coupon != null ? $order->coupon->code : '' !!}
                            </td>
                            <td>{!! format_datetimebr($order->date_registration) . ' (' . diff_time( $order->date_registration ) . ')'!!}</td>
                            <td>{!! $order->date_confirmation != null ? format_datetimebr($order->date_confirmation ). ' (' . diff_time( $order->date_confirmation ) . ')' : '' !!}</td>
                            <td class="text-right"> {!! number_format($order->price , 2, ',', '.' ) !!}</td>
                            <td class="text-right"> {!! number_format($order->discount_price , 2, ',', '.' ) !!}</td>
                            <td>{!! $order->action_buttons !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!--box box-success-->
    @endif


    @if ((access()->hasPermission('articles')) && ($articles != null) && ($articles->count() > 0))
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('strings.articles_not_active') }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('crud.articles.title') }}</th>
                        <th width="100">{{ trans('crud.articles.date') }}</th>
                        <th width="100">{{ trans('crud.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{!! $article->title !!}</td>
                            <td>{!! $article->date !!}</td>
                            <td>{!! $article->action_buttons !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!--box box-success-->
    @endif

    @if ((access()->hasPermission('tags')) && ($tags != null) && ($tags->count() > 0))
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('strings.tags_not_active') }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('crud.tags.name') }}</th>
                        <th>{{ trans('crud.tags.description') }}</th>
                        <th>{{ trans('crud.tags.active_at') }}</th>
                        <th>{{ trans('crud.tags.user_moderator') }}</th>
                        <th width="100">{{ trans('crud.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{!! $tag->name !!}</td>
                            <td>{!! $tag->description !!}</td>
                            <td>{!! format_datebr($tag->active_at) !!}</td>
                            <td>{!! $tag->userModeratorName !!}</td>
                            <td>{!! $tag->action_buttons !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div><!-- /.box-body -->
        </div><!--box box-success-->
    @endif


    @if ((access()->hasPermission('coursereports')))

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('strings.courses_sold') }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body" style="width:100% !important; height:30% !important;">
                <div class="row">
                    <div class="col-md-3 no-padding" style="margin: 30px;">
                        <canvas id="course-graph" ></canvas>
                    </div>
                    <div class="col-md-7" style="padding-top: 50px">
                        <div id="course-legend" class="pull-left"></div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box box-success-->
    @endif


    @if ((access()->hasPermission('coursereports')))

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('strings.annual_orders') }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body" style="width:100% !important; height:40% !important;">
                <div>
                    <canvas id="sales-graph" style="max-height: 300px;" ></canvas>
                </div>
                <div id="sales-legend"></div>
            </div><!-- /.box-body -->
        </div>
    @endif


@endsection