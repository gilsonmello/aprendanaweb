@extends('frontend.layouts.master-classroom')

@section('content')

    <header class="page-header">
        <h2>Base de Conhecimento</h2>
    </header>


    <section role="main" class="content-body">
        <div class="container">

            <br/>
            <div class="col-sm-12 card">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <h4>Busque por texto</h4>
                        <form action="{{ route('frontend.knowledge-search') }}" method="get">
                            <input type="text" id="search-form" style="width: 100%" class="form-control search-form typeahead" autocomplete="off" id="s" name="s" placeholder="Pesquise uma palavra chave e pressione Enter">
                        </form>
                    </div>
                </div>
                <div class="clearfix"></div>
                @if($questions != null )
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <h4>Filtrar por aula</h4>
                    {!! Form::select('ask_the_teacher_id', [" " => " "] + $questions->lists('lessonName', 'lesson_id')->all(), null, ['id' => 'question-lesson-filter','class' => 'select2', 'style' => "width: 100%"]) !!}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 text-left">
                        @if($questions->count() == 1)
                            <h4 style="font-weight: bold">Foi encontrado {{ $questions->count() }} resultado.</h4>
                        @else
                            <h4 style="font-weight: bold">Foram encontrados {{ $questions->count() }} resultados.</h4>
                        @endif
                    </div>
                </div>
            </div>
            <br>
            @foreach($questions as $question)
                <div class="post
                @if($question->lesson_id != null) lesson-post lesson-{{ $question->lesson_id }}
                @else question-post question-{{ $question->question_id }} @endif" style="padding: 20px">

                    <div class="post-content">

                        @if($question->lesson_id != null)
                            <span class="label-small label-primary lesson-tag">{{ $question->lesson->module->name }}- Aula {{  $question->lesson->sequence }}</span>
                        @elseif($question->question_id != null)
                            <span class="label-small label-primary question-tag" data-toggle="tooltip" title="{{ $question->questionObj->text }}">{{ $question->questionObj->exam }}</span>
                        @endif


                        <h3 class="entry-title-big">
                            <p style="font-size: 12pt"><strong>{{ $question->question }}</strong></p>
                        </h3>
                        <div class="entry-content">
                            <p>{{ $question->answer }}</p>
                        </div>
                            @if($question->data_answer != null)
                        <div class="entry-meta">
                            <p style="font-size: 12pt"><i>Respondido em {{ $question->data_answer }} </i></p>
                        </div>
                                @endif
                    </div>

                </div>






            @endforeach
@endif






        </div><!-- end: container -->
        <!-- start: page -->

        <!-- end: page -->
    </section>


@endsection