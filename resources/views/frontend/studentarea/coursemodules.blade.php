
@if (count($modules))

    <table class="table table-hover mb-none" style="font-size:1.6rem">
        <tbody>
        @foreach ($modules as $modulelist)
            {{--*/ $contentlist = get_module_first_content($modulelist); /*--}}
            {{--*/ $colorpercentage = ($modulelist->percentage_viewed < 40 ? "#D44233" : ($modulelist->percentage_viewed < 70 ? "#CDC144" : "#54ce4a")); /*--}}
            {{--*/ $content = get_module_first_content($modulelist); /*--}}
            <tr>
                <td width="80%">
                    <a href="/classroom/{!! $modulelist->course_id !!}/{!!  $modulelist->id !!}/{!! $content->lesson_id !!}/{!! $content->id !!}">
                       {{ $modulelist->name }}
                    </a>
                </td>
                <td width="20%" class="text-right" style="color: {{ $colorpercentage }};">
                    {{ number_format($modulelist->percentage_viewed, 0, ',', '.' ) }}%
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@else
    Não existem disciplinas para este curso.
@endif
