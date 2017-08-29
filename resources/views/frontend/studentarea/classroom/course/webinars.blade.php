<table class="table table-hover mb-none" style="margin-top: 20px; font-size:1.6rem">
    <tbody>
        @foreach ($webinars as $webinar)
            <tr>
                <td width="50%">{{ $webinar->title }} <p>{{ str_limit( strip_tags($webinar->description), 80) }}</p></td>
                <td width="25%">
                    <b>{{ $webinar->date }}</b>
                </td>
                <td width="25%">
                    @if ($webinar->youtube_live_url != '')
                        <a type="button" class="mb-xs mt-xs mr-xs btn btn-primary" href="{{ $webinar->youtube_live_url }}" target="_blank">Assistir Agora</a>
                    @else
                        <b>Em breve</b>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>