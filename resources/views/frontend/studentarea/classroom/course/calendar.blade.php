{{ $month = "" }}
@if (count($calendars))
<table class="table mb-none" style="margin-top: 20px;">
    <tbody>
        @foreach ($calendars as $calendar)
        @if ($month != month_year_br($calendar->date))
        <tr class="">
            <td colspan="2" style="font-size: 1.6rem;">{!! month_year_br($calendar->date) !!}</td>
        </tr>
        {{--*/ $month = month_year_br($calendar->date); /*--}}
        @endif
        <tr class="">
            <td><strong>{!! format_datebr($calendar->date) !!}</strong></td>
            <td>{!! $calendar->description !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<table class="table mb-none" style="margin-top: 20px;">
    <tbody>
        <tr>
            <td style="font-size: 1.6rem;">
                Não existem itens de calendário para este curso.
            </td>
        </tr>
</table>
@endif