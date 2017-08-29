{{ $message_finish }}
<br/>
<br/>
<b>{{ trans('strings.ticket') . ': ' . $id }}</b>
<br/>
<br/>
{{ trans('strings.message') . ': ' . $ticket_message }}
<br/>
<br/>
{{ trans('strings.sent_from') . ': ' . $from }}
<br/>
<br/>
<b>{{ trans('strings.to_read_ticket') }}</b>
<br/>
{{ url('admin/tickets/' . $id . '/edit') }}
<br/>
<br/>
<b>Brasil Jurídico</b>
