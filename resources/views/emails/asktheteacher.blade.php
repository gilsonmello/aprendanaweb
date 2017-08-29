<b>{{ trans('strings.asktheteacher') . ': ' . $id }}</b>
<br/>
<br/>
{{ trans('strings.message') . ': ' . $asktheteacher_message }}
<br/>
<br/>
{{ trans('strings.sent_from') . ': ' . $from }}
<br/>
<br/>
{{ trans('strings.reply_message') . ': ' . $reply_message }}
<br/>
<br/>
<b>{{ trans('strings.to_read_ticket') }}</b>
<br/>
{{ url('admin/asktheteacher/' . $id . '/edit') }}
<br/>
<br/>
<b>Brasil Jurídico</b>
