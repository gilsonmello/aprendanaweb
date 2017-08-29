<div class="row">
    {{--*/ $lastviewedcontent = get_last_viewed_content($enrollment) /*--}}
    <div class="col-md-3">
        @if (Carbon\Carbon::now() < Carbon\Carbon::parse( $enrollment->date_end ))
            @if( ($enrollment->views->isEmpty()) || (count($enrollment->views) == 0) || ($lastviewedcontent == null) || ($lastviewedcontent->lesson == null))
                <a type="button" href="/{{ get_url_from_content(get_first_content($enrollment))  }}/{{$enrollment->id}}" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;"><i class="fa fa-play"></i>&nbsp;&nbsp;Inicie o curso</a>
            @else
                <a type="button" href="/{{ get_url_from_content(get_last_viewed_content($enrollment)) }}/{{$enrollment->id}}" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;"><i class="fa fa-play"></i>&nbsp;&nbsp;Continuar vídeo-aulas</a>
            @endif
        @endif
    </div >
    <?php $count = 0;?>
    <!-- Fazendo loop para contar se há alguma anotação nessa matrícula -->
    <?php foreach($course->modules as $module){?>
        <!-- Contando se a disciplina possui alguma anotação -->
        <?php foreach ($module->lessons as $lesson){    
            foreach($lesson->contents as $content){
                //Pegando as anotação do usuário naquele bloco
                $notes = content_notes(Auth::user()->id, $content->id);
                //Atribuindo uma coleção ao objeto content
                $content->notes = $notes;
                //Condição para saber se a disciplina contém alguma anotação
                if(count($notes) > 0){
                    $count = 1;
                    break;
                }else{
                    $count = 0;
                }
            }
            if($count == 1){
                break;
            } 
        }
        if($count == 1){
            break;
        } 
    }?>
    <!-- -->
    
    <!-- Se existir alguma anotação daquele usuário no curso, mostrar botão exportar. -->
    @if($count > 0)
        <div class="col-md-3">
            <a type="button" target="_blank" href="{{ route('frontend.classroom.export-notes', $enrollment->id ) }}" class="mb-xs mt-xs mr-xs btn default btn-block" style="width:100%; font-size: 1.7rem;" >
                <i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Exportar Anotações
            </a>
        </div >
    @endif
    <!-- -->

    {{--@if(!Auth::user()->enrollments->reject(function ($item){ $item->partner_id == null; })->isEmpty())--}}
    @if($enrollment->partner_id == 5)
        <div class="col-md-3">
            <a type="button" href="{{ route('frontend.knowledge') }}" class="mb-xs mt-xs mr-xs btn default btn-block " style="width:100%; font-size: 1.7rem;" >
                <i class="fa fa-book"></i>&nbsp;&nbsp;Base de Conhecimento
            </a>
        </div>
    @endif
</div>
<br>
@if($enrollment->course_id == 375)
    <div class="row">
    <div class="card">
        <div class="display">
            <a type="button" href="{{ route('cart.buy_saap_80') }}">
                <img src="/img/system/descontosaap80.png" style="width: 100%">
            </a>
        </div>
    </div>
    </div>
@endif