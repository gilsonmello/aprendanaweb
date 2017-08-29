@extends ('backend.layouts.master')

@section ('title', trans('menus.tickets'))



@section('page-header')
    <h1>
        {{ trans('menus.tickets') }}
        <small>{{ trans('menus.all_tickets') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.tickets.index', trans('menus.tickets')) !!}</li>
@stop

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Filtro</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    {!! Form::open(array('route' => array('admin.tickets.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
    <div class="box-body">
        <div class="row">
        {!! Form::hidden('f_submit', '1'  ) !!}
        {!! Form::label('f_TicketController_id',  trans('crud.tickets.id'),  ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-1">
        {!! Form::text('f_TicketController_id', $ticketcontrollerid, ['class' => 'form-control']) !!}
        </div>
        {!! Form::label('f_TicketController_is_replied',  trans('strings.is_replied'), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-2 no-padding" style="margin-top:5px;">
            <label>{!! Form::radio('f_TicketController_is_replied', '2',($ticketcontrollerisreplied ===  '2' ? true : false)) !!} {!!trans('strings.all_male')!!} </label> &nbsp;
            <label>{!! Form::radio('f_TicketController_is_replied', '1',($ticketcontrollerisreplied ===  '1' ? true : false)) !!} {!!trans('strings.yes')!!} </label> &nbsp;
            <label>{!! Form::radio('f_TicketController_is_replied', '0',($ticketcontrollerisreplied ===  '0' ? true : false)) !!} {!!trans('strings.no')!!}</label>        
        </div>
        {!! Form::label('f_TicketController_is_finished',  trans('strings.is_finished'), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-2 no-padding" style="margin-top:5px;">
            <label>{!! Form::radio('f_TicketController_is_finished', '2',($ticketcontrollerisfinished ===  '2' ? true : false)) !!} {!!trans('strings.all_male')!!}</label>&nbsp;
            <label>{!! Form::radio('f_TicketController_is_finished', '1',($ticketcontrollerisfinished ===  '1' ? true : false)) !!} {!!trans('strings.yes')!!}</label>&nbsp;
            <label>{!! Form::radio('f_TicketController_is_finished', '0',($ticketcontrollerisfinished ===  '0' ? true : false)) !!} {!!trans('strings.no')!!}</label>
        </div>
        </div>
        <hr>
        <div class="row">
            {!! Form::label('f_TicketController_date_begin',  trans('strings.updated_date_begin'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-2">
                {!! Form::text('f_TicketController_date_begin', $ticketcontrollerdatebegin, ['class' => 'datemask form-control', 'style' => 'width:80%; display:inline-block;margin-right:10px;']) !!}            
                <strong>{!! Form::label('f_TicketController_date_end',  trans('strings.updated_date_end') ) !!}</strong>
            </div>
            <div class="col-md-2">
            {!! Form::text('f_TicketController_date_end', $ticketcontrollerdateend, ['class' => 'datemask form-control']  ) !!}
            </div>
                {!! Form::label('f_TicketController_dead_line_begin',  trans('strings.dead_line_date_begin'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-2">
                {!! Form::text('f_TicketController_dead_line_begin', $ticketcontrollerdeadlinebegin, ['class' => 'datemask form-control', 'style' => 'width:80%; display:inline-block;margin-right:10px;']) !!}
                <strong>{!! Form::label('f_TicketController_dead_line_end',  trans('strings.dead_line_date_end')) !!}</strong>
            </div>
            <div class="col-md-2">
                {!! Form::text('f_TicketController_dead_line_end', $ticketcontrollerdeadlineend, ['class' => 'datemask form-control']  ) !!}
            </div>
        </div>
        <hr></hr>
        <div class="row">
            {!! Form::label('f_TicketController_sector_id', trans('validation.attributes.sector'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-5">
                {!! Form::select('f_TicketController_sector_id', ['' => ''] + $sectors->lists('name', 'id')->all(), $ticketcontrollersectorid, ['class' => 'select2']) !!}
            </div>
            <div class="col-md-2">
                <div>
                    <div class="sw-green create-permissions-switch">
                        <div class="onoffswitch">
                            <label class="control-label">Exportar para CSV</label>
                            <input value="1" name="f_TicketController_export_to_csv" class="toggleBtn onoffswitch-checkbox" id="export_to_csv" type="checkbox">
                            <label for="export_to_csv" class="onoffswitch-label">
                                <div class="onoffswitch-inner"></div>
                                <div class="onoffswitch-switch"></div>
                            </label>
                        </div>
                    </div><!--green checkbox-->
                </div>
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
                <td><nobr>{!! format_datetimebr($ticket->date_dead_line_reply) !!}</nobr></td>
                <td><nobr>{!! format_datetimebr($ticket->updated_at) !!}</nobr></td>
                <td> {!! $ticket->is_replied_label !!}</td>
                <td> {!! $ticket->is_finished_label !!}</td>
                <td>{!! $ticket->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $tickets->total() !!} {{ trans('crud.tickets.total') }}
    </div>

    <div class="pull-right">
        {!! $tickets->render() !!}
    </div>

    <div class="clearfix"></div>
@stop