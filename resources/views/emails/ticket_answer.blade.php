<b>{{ trans('strings.ticket') . ': ' . $id }}</b>
<br/>
<br/>
<br/>
<b>{!! trans('strings.sent_from') !!}:</b> {!! $from !!} [{{ $fromemail }}]
<br/>
<br/>
<b>{!!  trans('strings.message') !!}:</b> {!! $ticket_message !!}
<br/>
________________________
<br/>
{!!  $reply_message !!}
<br/>
<b>{{ trans('strings.to_read_ticket') }}</b>
<br/>
{{ url('admin/tickets/' . $id . '/edit') }}
<br/>
<br/>
<b>Brasil Jurídico</b>
