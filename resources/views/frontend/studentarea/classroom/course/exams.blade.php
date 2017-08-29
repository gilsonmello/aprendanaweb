
    @if (( $course->analysis != null) && ( $course->analysis != ''))
        <div class="row">
        <div class="col-md-3">
            <a type="button" href="{{ route('frontend.classroom.analysis', $enrollment->id ) }}" class="mb-xs mt-xs mr-xs btn btn-primary green-jungle" style="width:100%; font-size: 1.7rem;" ><i class="fa fa-circle-o-notch"></i>&nbsp;&nbsp;Análise 360º</a>
        </div >
        </div >
    @endif

    <table class="table table-hover mb-none" style="margin-top: 20px; font-size:1.6rem">

    <tbody>
    @foreach ($examenrollments as $examenrollment)

        {{--*/  $best = get_best_result($examenrollment) /*--}}
        <tr>
            <td width="50%"><a href="/exam/intro/{{ $examenrollment->id  }}">SAAP | {{ str_limit($examenrollment->exam->title, 80) }}</a></td>
            <td width="25%">
                @if ($best != null)
                    <a href="/exam/result/{{ $best->id  }}">
                                                    <span class="label label-md @if( (($best->grade * 100)/ $examenrollment->exam->questions_count)  >= $examenrollment->exam->minimum_percentage )
                                                            label-success
                                                            @else
                                                            label-danger
                                                            @endif">{{ number_format($best->grade * 100 / $examenrollment->exam->questions_count,0)  }}%</span>
                        &nbsp;&nbsp;<span class="font-green-jungle">
                                                    <i class="fa fa-check"></i><strong> {{ number_format($best->grade,0) }}</strong> acertos</span>
                        &nbsp;
                                                <span class="font-red-flamingo">
                                                    <i class="fa fa-close"></i> {{ number_format($examenrollment->exam->questions_count - $best->grade, 0) }} erros</span>
                    </a>
                @else
                    &nbsp;
                @endif
            </td>
            <td width="25%"><i class="fa fa-pencil-square-o"></i> {{$attempt =  get_attempted($examenrollment) }}/{{$examenrollment->exam_max_tries}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
