@extends ('backend.layouts.master')

@section ('title', trans('menus.ticket_management') . ' | ' . trans('menus.edit_ticket'))

@section('page-header')
    <h1>
        {{ trans('menus.tickets') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.tickets.index', trans('menus.tickets')) !!}</li>
    <li class="active">{!! link_to_route('admin.tickets.create', trans('menus.edit_ticket')) !!}</li>
@stop

@section('content')

@if (access()->hasPermission('userstudents'))
    <div class="row">
            <div class="col-lg-12 text-right">
                <div class="pull-right" style="margin-bottom:10px">
                    <a href="{{route('admin.userstudents.edit', $ticket->userstudent->id)}}" class="btn btn-primary btn-xs">{{ trans('strings.student') }}</a>
                    <a href="{{route('admin.userstudents.enrollments', $ticket->userstudent->id)}}" class="btn btn-primary btn-xs">{{ trans('menus.courses') }}</a>
                    <a href="{{route('admin.userstudents.exams', $ticket->userstudent->id)}}" class="btn btn-primary btn-xs">{{ trans('menus.exams') }}</a>
                </div>
            </div>
                @endif
    </div>
    {!! Form::model($ticket, ['route' => ['admin.tickets.update', $ticket->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('student', trans('strings.student'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-5">
                {!! Form::text('student', $ticket->userStudent->name, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
            </div>
            {!! Form::label('created_at', trans('strings.created_at'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('created_at', format_datetimebr($ticket->created_at) . ' (' . diff_time( $ticket->created_at ) . ')', ['class' => 'form-control', 'disabled' => 'disabled']) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('sector', trans('strings.sector'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-5">
            {!! Form::text('sector', $ticket->sector->name, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
        {!! Form::label('date_dead_line_reply', trans('strings.date_dead_line_reply'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-3">
            {!! Form::text('date_dead_line_reply',format_datetimebr( $ticket->date_dead_line_reply) . ' (' . diff_time( $ticket->date_dead_line_reply ) . ')', ['class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div><!--form control-->

        @if ($ticket->content_id != null )
            <div class="form-group">
                {!! Form::label('lesson', trans('strings.lesson'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('lesson', $ticket->content->lesson->module->course->title . ' - ' .
                                        $ticket->content->lesson->module->name . ' - Aula ' .
                                        $ticket->content->lesson->sequence . ' - Bloco ' .
                                        $ticket->content->sequence
                    , ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                </div>
            </div><!--form control-->
        @endif


    <div class="form-group">
        {!! Form::label('message', trans('strings.message'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-md-10" style="padding-top: 5px">
            {!! nl2br($ticket->message) !!}
        </div>
    </div><!--form control-->
    <hr>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.ticketmessages.user') }}</th>
            <th>{{ trans('crud.ticketmessages.created_at') }}</th>
            <th>{{ trans('crud.ticketmessages.message') }}</th>
            @if ($ticket->is_finished != 1)
            <th>{{ trans('crud.actions') }}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($messages as $message)
            <tr>
                <td>{!! $message->user->name !!}</td>
                <td>{!! format_datetimebr($message->created_at) . ' (' . diff_time( $message->created_at ) . ')'!!}</td>
                <td width="60%">{!! nl2br($message->message) !!}</td>
                @if ($ticket->is_finished != 1)
                <td>{!! $message->action_buttons !!}</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

    @if ($ticket->is_finished != 1)
    <br/>
    {!! Form::close() !!}

    {!! Form::open(array('route' => array('admin.tickets.message.store'), 'method' => 'post'))  !!}
    {!! Form::hidden('ticket_id', $ticket->id  ) !!}
    {!! Form::label('message',  trans('strings.new_message_ticket')) !!}
    <br/>
    {!! Form::textarea('message', null, ['cols' => '100'] ) !!}
    <br/>
    {!! Form::submit( trans('strings.send'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <br/>
    {!! Form::open(array('route' => array('admin.tickets.finish'), 'method' => 'post', 'onsubmit' => 'return confirm("'. trans('crud.tickets.finish') . '");'))  !!}
    {!! Form::hidden('ticket_id', $ticket->id  ) !!}
    {!! Form::submit( trans('strings.finish'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    @endif
    <br/>
    <div class="pull-left">
        <a href="{{route('admin.tickets.index', ['page' => Session::get('lastpage', '1')] )}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
    </div>
@stop