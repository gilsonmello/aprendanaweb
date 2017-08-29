@if (count($alerts))
    <table class="table mb-none " style="margin-top: 20px;">
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
    <table class="table mb-none" style="margin-top: 20px;">
        <tbody>
        <tr>
            <td style="font-size: 1.6rem;">Não existem avisos para este curso.</td>
        </tr>
    </table>
@endif