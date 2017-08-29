<div class="col-md-2" id="side-panel">
    <div id="teacher-advice" class="row" style="padding-top: 30px;">
        @include('frontend.studentarea.classroom.course.teacher_advice')
    </div>
</div>


<div class="col-md-10 no-padding"  >
    <div class="row">

        @if (($course->id == 572) || ($course->id == 573) || ($course->id == 574) || ($course->id == 575))
        <div class="col-md-3">
            <a type="button" href="{{ route('frontend.classroom.tutorial' ) }}" class="mb-xs mt-xs mr-xs btn default btn-block" style="width:100%; font-size: 1.7rem;" ><i class="fa fa-question"></i>&nbsp;Como Funciona</a>
        </div>
        <div class="col-md-3">
            <a type="button" href="{{ route('frontend.classroom.manual' ) }}" class="mb-xs mt-xs mr-xs btn default btn-block" style="width:100%; font-size: 1.7rem;" ><i class="fa fa-user"></i>&nbsp;&nbsp;Manual do Aluno</a>
        </div>
        @endif

        @if (( $course->analysis != null) && ( $course->analysis != ''))
        <div class="col-md-3">
            <a type="button" href="{{ route('frontend.classroom.analysis', $enrollment->id ) }}" class="mb-xs mt-xs mr-xs btn default green-jungle" style="width:100%; font-size: 1.7rem;" >
                <i class="fa fa-circle-o-notch"></i>&nbsp;&nbsp;Análise 360º
            </a>
        </div >
        @endif

        <div class="col-md-3">
            <a type="button" href="#course-contents-tab" class="mb-xs mt-xs mr-xs btn default btn-block" style="width:100%; font-size: 1.7rem;" ><i class="fa fa-exclamation-circle"></i> Conteúdo Programático</a>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-content  text-center">
                    <p style="font-size: 3rem; color: #456D8C;"><i class="fa fa-calendar"></i></p>
                    <br>
                    @if (Carbon\Carbon::now() < Carbon\Carbon::parse( $enrollment->date_end ))
                    <p style="font-size: 4rem;">{{ Carbon\Carbon::now()->diffInDays( Carbon\Carbon::parse( $enrollment->date_end )) }} dias</p>
                    <br>
                    <p style="font-size: 1.5rem;">Para concluir o curso</p>
                    @else
                    <p style="font-size: 4rem;">Encerrado</p>
                    <br>
                    @endif


                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-content  text-center">
                    <p style="font-size: 3rem; color: #456D8C;"><i class="fa fa-eye"></i></p>
                    <br>
                    <p style="font-size: 4rem;">{{ $course->max_view }}</p>
                    <br>
                    <p style="font-size: 1.5rem;">Visualizações por bloco</p>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="display">
                    <div class="number">
                        @if($actual = get_total_percentage_completed($enrollment))@endif

                        <h3 class=" @if(abs($actual - $ideal) < 10 )
                            font-yellow-saffron
                            @elseif($actual - $ideal > 10)
                            font-green-jungle
                            @else
                            font-red-flamingo
                            @endif">
                            <span data-counter="counterup" data-value="{{ $actual }}">{{$actual}}</span>
                            <small class="@if(abs($actual - $ideal) < 10 )
                                   font-yellow-saffron
                                   @elseif($actual - $ideal > 10)
                                   font-green-jungle
                                   @else
                                   font-red-flamingo
                                   @endif">%</small>
                        </h3>
                        <small>ASSISTIDO</small>
                    </div>
                    <div class="icon">
                        <i class="icon-like"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress" style="height:4px">
                        <span style="width: {{ $actual }}%;" class="progress-bar progress-bar-success @if(abs($actual - $ideal) < 10 )
                              yellow-saffron
                              @elseif($actual - $ideal > 10)
                              green-jungle
                              @else
                              red-flamingo
                              @endif">
                            <span class="sr-only">{{ $actual }}% progress</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"> AULAS ASSISTIDAS </div>
                        <div class="status-number"> {{ lessons_completed($enrollment) }} </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-3">
            <div class="card">

                <div class="display">
                    <div class="number">
                        <h3 class="font-blue-steel">
                            <span data-counter="counterup" data-value="{{ $ideal = get_ideal_percentage($enrollment->date_end,$enrollment->date_begin) }}">{{ $ideal }}</span>
                            <small class="font-blue-steel">%</small>
                        </h3>
                        <small>ESPERADO</small>
                    </div>
                    <div class="icon">
                        <i class="icon-screen-desktop"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress" style="height:4px">
                        <span style="width: {{ $ideal }}%;" class="progress-bar progress-bar-success blue-steel">
                            <span class="sr-only">{{ $ideal }}%</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"> AULAS ESPERADAS </div>
                        <div class="status-number"> {{ round(get_lessons_count_by_course($enrollment) * ($ideal / 100),0,PHP_ROUND_HALF_UP) }} </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


