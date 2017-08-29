@extends('frontend.layouts.master-classroom')

@section('content')
    <section role="main" class="content-body">
        <div id="course" class="container">
            <div class="row">
                <div class="col-md-12" >
                    <div id="tabs-content" class="tab-content">
                        <div id="module-tab" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-6" style="float: left !important; ">
                                    <h3>
                                        <strong>
                                            {{ $course->title}}
                                        </strong>
                                    </h3>
                                </div >
                                <div class="col-md-3" style="float: right !important; ">
                                    <a id="btn-export" type="button" class="mb-xs mt-xs mr-xs btn btn-primary green-jungle" style="width:100%; font-size: 1.7rem;" >
                                        <i class="fa fa-print"></i>&nbsp;&nbsp;Imprimir Anotações
                                    </a>
                                </div >
                            </div>
                            <section id="content-export" class="panel">
                                <div class="panel-body">
                                    <table class="table table-hover mb-none" style="margin-top: 20px; font-size:1.6rem">
                                        <tbody>
                                            <?php $count = 0; $hasContent = false; ?>
                                            <?php foreach($course->modules as $module){ ?>
                                                
                                                <!-- Contando se a disciplina possui alguma anotação -->
                                                <?php foreach ($module->lessons as $lesson){    
                                                    foreach($lesson->contents as $content){
                                                        //Pegando as anotação do usuário naquele bloco
                                                        $notes = content_notes(Auth::user()->id, $content->id);
                                                        //Atribuindo uma coleção ao objeto content
                                                        if(count($notes) > 0){
                                                            $hasContent = true;
                                                            $content->notes = $notes;
                                                        }
                                                    }
                                                }
                                                //Fim do contador se possui alguma anotação na disciplina
                                                
                                                //Se possuir alguma anotação, faço a impressão da disciplina
                                                if($count == 0 && $hasContent == true){ ?>
                                                    <tr>
                                                        <td style="border: none;" align="left">
                                                            <h3>
                                                                {{ $module->name }}
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                                @foreach($module->lessons as $lesson)
                                                    <!-- Resetando a variável count -->
                                                    <?php $count = 0; ?>
                                                    @foreach($lesson->contents as $content)
                                                        <!-- Se existir alguma anotaçao no bloco, entra no loop -->
                                                        @if(count($content->notes) > 0)
                                                            @foreach($content->notes as $note)
                                                                <!-- Se não foi impresso a disciplina nenhuma vez, faz a impressao-->
                                                                @if($count == 0)
                                                                    <tr>
                                                                        <td align="left" style="border-top: none;" >
                                                                            <p style="border-top: none; margin-left: 40px; margin-top: 7px; margin-bottom: 0;">
                                                                                <strong>
                                                                                    Aula {{ $lesson->sequence}} - {{ $lesson->title}}
                                                                                </strong>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $count++; ?>
                                                                @endif
                                                                <!-- Se já foi impresso a disciplina, incremento a variavel count, para bloquear a próxima impressão -->
                                                                <tr>
                                                                    <td align="left" style="border-top: none; padding: 2px;">

                                                                        <p style=" margin-left: 70px; margin-top: 0; margin-bottom: 0;">Bloco {{ $note->content->sequence}} - {{ gmdate("i:s", $note->video_index_seconds ) }} - {{ $note->note }}</p>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <?php $count = 0;?>
                                                        @endif
                                                        <!--Fim da condição para saber se tem alguma anotação no bloco -->
                                                    @endforeach
                                                @endforeach
                                            <?php $hasContent = false;}?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Variável para conter o arquivo classroom.css do gulp -->
    <script type="text/javascript">
        var css = '<link rel="stylesheet" media="all" href=<?php echo elixir('css/classroom.css');?> type="text/css">';
    </script>
    <!--  -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@endsection