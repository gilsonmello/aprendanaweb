
@if ($remaining = count($questions->reject(function($item){ return $item->grade !== null; })))@endif
 <table class="table mb-none table-striped">
    <tbody id="questions-remaining" data-remaining="{{ $remaining }}">
    @foreach ($questions as $question)

        <tr
                @if($question->grade !== null)
                style="cursor: pointer;"
                @else
                style="cursor: pointer; font-weight: bold"
                @endif

                onclick="javascript: jump_to_question( {!!  $question->id !!} );">

            @if($question->grade === null)
                <td><i class="fa fa-square-o"></i></td>

            @else
                <td><i class="fa fa-check-square-o"></i></td>
            @endif


            <td style="font-size: 1.8rem;" width="25%">Questão {!! $question->order !!}</td>
            <td style="font-size: 1.8rem;">{!! str_limit($question->question->text, 100) !!}</td>
        {{--<td style="font-size: 1.8rem;"><a href="/classroom/{!! $module->course_id !!}/{!!  $module->id !!}/{!! $content->lesson_id !!}/{!! $content->id !!}">  >>  </a></td>--}}

    </tr>
    @endforeach
</tbody>
</table>

