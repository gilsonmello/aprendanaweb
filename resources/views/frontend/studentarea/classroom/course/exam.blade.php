@foreach ($exams as $module_id => $group)
    <a data-toggle="collapse" data-target="#classes-exam{{ $module_id }}" style="cursor: pointer;">
        <i class="fa fa-folder"></i>&nbsp;&nbsp;
        {{ $group->first()->module_name }}
    </a>

    <div id="classes-exam{{ $module_id }}" class="collapse" style="width: 100%; padding-left: 30px; cursor: pointer;">
        @foreach ($group as $exam)
            <a data-toggle="collapse" data-target="#exam{{  $exam->lesson_id }}">
                <i class="fa fa-folder"></i>&nbsp;&nbsp;
                Aula {{ $exam->lesson_sequence }}
            </a>

            @if($enrollment_exam = get_enrollment_by_user_course_enrollment($exam->id,$enrollment))@endif

            @if($enrollment_exam != null)


                <div id="exam{{ $exam->lesson_id }}"  class="collapse" style="width: 100%; padding-left:30px;  cursor: pointer;">

                    @if($enrollment_exam->date_begin < Carbon\Carbon::now())

                        @if($enrollment_exam->executions->isEmpty())
                            <i class="fa fa-square-o"></i><a class="course-exam-label first-try exam-begin" data-enrollment="{{ $enrollment_exam->id }}"> Executar</a><br/>
                        @else
                            @foreach($enrollment_exam->executions->filter(function($item){ return $item->finished == 1 || $item->simulation_mode == 1;}) as $execution)
                                <i class="fa fa-check-square-o"></i><a href="/exam/result/{{ $execution->id }}" class="course-exam-label"> Execução {{ $execution->attempt }}: &nbsp;<b> {{ floor(($execution->grade * 100)/ $execution->enrollment->exam->questions_count)  }}% </b>[VER RESULTADO]</a><br/>
                            @endforeach


                            @if(!is_exam_tries_over($enrollment_exam))
                                @if($enrollment_exam->executions->whereLoose('finished',0)->isEmpty() || $enrollment_exam->executions->whereLoose('finished',0)->first()->simulation_mode == 1)
                                    <i class="fa fa-square-o"></i><a class="exam-begin" data-enrollment="{{ $enrollment_exam->id }}" data-first-time="{{ 1 }}" href="/exam/intro/{{ $exam->id  }}"> Próxima Execução</a>
                                @else
                                    <i class="fa fa-square-o"></i><a  href="/exam/{{ $enrollment_exam->id  }}"> Continue - Questão @if($enrollment_exam->executions->whereLoose('finished',0)->first()->last_question_execution != null){{ $enrollment_exam->executions->whereLoose('finished',0)->first()->last_question_execution->order + 1}} @else 1 @endif</a>
                                @endif

                            @endif
                        @endif

                    @else
                        <i>Esse SAAP estará disponível em {{ format_datetimebr($enrollment_exam->date_begin) }}</i>
                    @endif
                </div>
                <br/>
            @endif


        @endforeach


    </div>
    <br/>
    <br/>
@endforeach
