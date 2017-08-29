
    <table class="table table-hover mb-none" style="margin-top: 20px; font-size:1.6rem">

    <tbody>
    @foreach ($workshops as $workshop)

        <tr>
            <td width="50%">{{ str_limit($workshop->description, 80) }}</td>
            <td width="25%">
            <b>{{ count($workshop->activities) }}</b> atividades
            </td>
            <td width="25%">
                @if ($workshop->active == 1)
                    <a type="button" class="mb-xs mt-xs mr-xs btn btn-primary" href="/classroom/workshops/{{ $enrollment->id  }}/{{ $workshop->id  }}">Ir para {{ $course->custom_workshop_title != null ? $course->custom_workshop_title  : "Oficina" }} </a>
                @else
                    Abertura <b>{{ format_datebr( $workshop->begin ) }}</b>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
