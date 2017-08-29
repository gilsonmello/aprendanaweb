<br>
<br>
<h2 align="left">Protocolo de Entrega| {{$workshop_activity->activity->description}} da {{ $workshop_activity->workshop->description }}</h2>

<table cellpadding="0" cellspacing="0" border="0">

    <tr>
        <td align="left" width="10%"><strong>Nome:</strong></td><td align="left">{{Auth::user()->name}}</td>
    </tr>
    <tr>
        <td align="left"><strong>CPF:</strong></td><td align="left">{{Auth::user()->personal_id}}</td>
    </tr>
</table>
<br>
<br>
<br>
<br>
<table cellpadding="0" cellspacing="0" border="0">

    <tr>
        <td align="left" padding="20"><strong>Questão entregue em: {{ format_datebr($workshop_activity->date_submit) }}</strong></td>
    </tr>

</table>

