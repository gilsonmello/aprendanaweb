<div id="examContentDiv" style="padding: 20px; font-size: 1.5rem;">






    <table class="table table-stripped table-responsive">
        <caption>Critérios para certificação</caption>
        <thead>
        <tr>
            <th>Critério</th>
            <th>Esperado</th>
            <th>Atingido</th>
        </tr>
        </thead>
        <tbody>
        <tr @if( $enrollment->course->percentage_certificate <= $actual) class="table-success" style="background-color: rgba(200,255,200,0.5)" @else class="table-danger" style="background-color: rgba(255,200,200,0.5)" @endif>
            <td>Aulas assistidas</td>
            <td>{{ $enrollment->course->percentage_certificate }}%</td>
            <td>{{ $actual }} %</td>
        </tr>
        @if($enrollment->course->groups != null && !$enrollment->course->groups->isEmpty())

            @if($execution = $enrollment->executions->whereLoose('finished','1')->first()) @endif

            <tr @if($execution != null && (($execution->grade * 100) / $execution->questions_executions->count()) >= $enrollment->course->minimum_percentage) class="table-success" style="background-color: rgba(200,255,200,0.5)" @else class="table-danger" style="background-color: rgba(255,200,200,0.5)" @endif>
                <td>Avaliação</td>
                <td>{{ $enrollment->course->minimum_percentage }}%</td>
                <td>{{ $execution == null ? "Não realizado" : (($execution->grade * 100) / $execution->questions_executions->count()) . "%" }}  </td>
            </tr>
        @endif
        @if($enrollment->course->certification_individual_auth == 1)

            <tr @if($enrollment->certification_individual_date != null)  class="table-success" style="background-color: rgba(200,255,200,0.5)"  @else lass="table-danger" style="background-color: rgba(255,200,200,0.5)" @endif >
                <td>{{$enrollment->course->certification_individual_text}}</td>
                <td>Sim</td>
                <td>{{ $enrollment->certification_individual_date == null ? "Não" : "Sim" }}</td>
            </tr>

        @endif


        </tbody>

    </table>

    @if(Auth::user()->personal_id == null)
        Para emitir o certificado, primeiro informe o seu CPF no <a href="{!! Route('profile.edit', Auth::user()->id) !!}">perfil</a>.
    @endif

    @if($enrollment->course->groups != null && !$enrollment->course->groups->isEmpty())
        @if($execution = $enrollment->executions->whereLoose('finished',1)->first()) @endif

        @if($execution == null)
                @if( $enrollment->course->percentage_certificate <= $actual)

                    <div class="row" style="font-weight: bold">
                        <div class="col-md-12">
                            <br/>
                            <p>A Avaliação de Rendimento permite avaliar o seu aprendizado durante o curso, medindo sua aptidão para obter o certificado.</p>
                            <p>Na Avaliação de Rendimento, somente após concluir todo o simulado, respondendo a todas as questões, o aluno terá acesso aos comentários dos professores. Assim, será necessário responder todas as questões, marcando suas alternativas, para ao final  ter acesso as respostas correlatas e comentários dos professores.</p>
                            <p>Na Avaliação de Rendimento será possível alterar as respostas das questões já marcadas. Aquelas questões que não forem respondidas, seja pelo esgotamento do tempo, seja pela finalização do SAAP pelo aluno, serão computadas como erro.</p>
                        </div>
                    </div>

            Para cumprir o critério da avaliação, você precisa realizar ela clicando no botão abaixo:
                <a  type="button"  href="{{ route('frontend.final.exam', $enrollment->id ) }}" class="mt-xs mr-xs btn btn-success" style="width:100%; font-size: 1.7rem;">Iniciar a Prova do Curso</a>

                    @else
                    A Avaliação estará disponível assim que você atingir a porcentagem mínima para visualização das aulas
                    @endif

            @elseif(($execution->grade * 100) / $execution->questions_executions->count()
        < $enrollment->course->minimum_percentage )

            Você não conseguiu pontuação o suficiente para adquirir o certificado. Para esclarecimentos entre em contato com o nosso atendimento.<br/>
                <a  type="button"  href="{{ Route('student.ticketstudents.index') }}" class="mt-xs mr-xs btn btn-primary" style="font-size: 1.7rem;">Fale Conosco</a>

        @else


            @if($enrollment->course->certification_individual_auth == '1' && $enrollment->certification_individual_date == null)
                Ainda há critérios a serem cumpridos. Para esclarecimentos entre em contato com o nosso atendimento.<br/>
                    <a  type="button"  href="{{ Route('student.ticketstudents.index') }}" class="mt-xs mr-xs btn btn-primary" style="font-size: 1.7rem;">Fale Conosco</a>
                @else
            <a type="button" href="{{ route('frontend.classroom.certificate', $enrollment->id ) }}" class="mb-xs mt-xs mr-xs btn btn-primary green-jungle" style="width:100%; font-size: 1.7rem; "><i class="fa fa-file"></i>&nbsp;&nbsp;Emitir Certificado</a>
                @endif
        @endif
    @elseif( ($actual >= $enrollment->course->percentage_certificate) && ($enrollment->student->personal_id != null)  && ($enrollment->student->personal_id != ''))
        @if($enrollment->course->certification_individual_auth == 1 && $enrollment->certification_individual_date == null)
            Ainda há critérios a serem cumpridos. Para esclarecimentos entre em contato com o nosso atendimento.<br/>
            <a  type="button"  href="{{ Route('student.ticketstudents.index') }}" class="mt-xs mr-xs btn btn-primary" style="font-size: 1.7rem;">Fale Conosco</a>
            @else
        <a type="button" href="{{ route('frontend.classroom.certificate', $enrollment->id ) }}" class="mb-xs mt-xs mr-xs btn btn-primary green-jungle" style="width:100%; font-size: 1.7rem; "><i class="fa fa-file"></i>&nbsp;&nbsp;Emitir Certificado</a>
        @endif

    @else

        <br><br>
        @if(!empty($enrollment->course->certification) && isset($enrollment->course))
            {!! $enrollment->course->certification !!}
            <br><br>
        @endif


    @endif
</div>