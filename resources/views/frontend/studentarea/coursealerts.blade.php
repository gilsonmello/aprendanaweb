
@if (count($alerts))
 <table class="table mb-none">
    <thead>
        <tr>
            <th>Data</th>
            <th>Aviso</th>
        </tr>
    </thead>
    <tbody>

    @foreach ($alerts as $alert)
        <tr class="">
            <td>{!! format_datebr($alert->date) !!}</td>
            <td>{!! $alert->description !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@else
Não existem avisos para este curso.
@endif

