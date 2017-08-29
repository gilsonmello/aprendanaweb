<h1>{{$course->title}}</h1>
<br>
<table cellpadding="0" cellspacing="0" border="1">
    <tr>
        <th width="30%"><b>Disciplina</b></th>
        <th width="30%"><b>Professor</b></th>
        <th width="10%"><b>Aulas</b></th>
        <th width="30%"><b>Titulação</b></th>
    </tr>
        @foreach($course->modules as $module)
            {{--*/ $ini = 1 /*--}}
            @foreach($module->teachers as $objTeacher)
                <tr>
                    @if ($ini == 1)
                        <td rowspan="{{ count($module->teachers) }}">{{ $module->name }}</td>
                        {{--*/ $ini = 0 /*--}}
                    @endif
                    <td>{{ $objTeacher->name }}</td>
                    <td>{{ $objTeacher->lesson_teachers }}</td>
                    <td>{{ $objTeacher->educational_title }}</td>
                </tr>
            @endforeach
        @endforeach
</table>