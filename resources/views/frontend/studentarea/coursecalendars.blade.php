{{ $month = "" }}
@if (count($calendars))
 <table class="table mb-none">
    <tbody>
    @foreach ($calendars as $calendar)
        @if ($month != month_year_br($calendar->date))
            <tr class="">
                <td colspan="2" style="font-size: 1.8rem;"><b>{!! month_year_br($calendar->date) !!}</b></td>
            </tr>
            {{--*/ $month = month_year_br($calendar->date); /*--}}
        @endif
        <tr class="">
         <td>{!! Carbon\Carbon::parse($calendar->date)->format('d') !!}</td>
         <td>{!! $calendar->description !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@else

    Não existem itens de calendário para este curso.
@endif

