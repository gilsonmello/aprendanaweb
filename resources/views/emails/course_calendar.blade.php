@foreach($data as $courseCalendar)
	<b>{{ trans('strings.course') . ': ' . $courseCalendar->course_title }}</b>
	<br/>
	<br/>
	{{ trans('strings.event') . ': ' . $courseCalendar->description }}
	<br/>
	<br/>
	{{ trans('strings.date') . ': ' . format_br($courseCalendar->date, 'd/m/Y H:i:s') }}
@endforeach
<br/>
<br/>
<b>Atenciosamente Brasil Jurídico</b>
