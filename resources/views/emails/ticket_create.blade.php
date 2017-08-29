<b>{{ trans('strings.ticket') . ': ' . $id }}</b>
<br/>
<br/>
<br/>
<b>{{ trans('strings.sent_from') }}:</b> {{ $from }} [{{ $fromemail }}]
<br/>
<br/>
<b>{{ trans('strings.course') }}:</b> {{ $course }}
<br/>
<br/>
<b>{!!  trans('strings.subject') !!}:</b> {!!  $sector !!}
<br/>
<br/>
<b>{!!  trans('strings.message') !!}:</b> {!! $ticket_message !!}
<br/>
<br/>
<br/>
<b>{{ trans('strings.to_read_ticket') }}</b>
<br/>
{{ url('admin/tickets/' . $id . '/edit') }}
<br/>
<br/>
<b>Brasil Jurídico</b>
