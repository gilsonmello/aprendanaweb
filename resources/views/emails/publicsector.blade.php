<b>Enviado por:</b> {!! $from_name !!} [{{ $from_email }}]
<br/>
<br/>
<b>Telefones:</b> {!! $from_phone !!} / {!! $from_cel !!}
<br/>
<b>Organização:</b> {!! $from_organization !!}
<br/>
<b>Observação:</b> {!! $from_obs !!}
<br/>
<b>Colaboradores alunos:</b> {!! $number !!}
<br/>
<br/>
<table cellspacing="0">
    <tr>
        <th style="border: 1px solid #999; text-align: left; padding: 10px;">Curso</th>

    </tr>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td width="80%" style="border: 1px solid #999; text-align: left; padding: 10px;">{{ $item['title'] }}</td>

        </tr>
        @endforeach
    </tbody>
</table>
<br/>
<br/>
<b>Brasil Jurídico | Gestão Pública</b>
