<div id="results" data-partial="{{ $partial }}" data-total="{{ $total }}" data-rights="{{ $rights }}" data-total-time="{{ $total_time }}" data-time="{{ $time }}" >

    @if($next == null)
        <div class="row" style="padding:15px;">

            <div class="col-md-6" style="text-align:center">
                <div class="container" style="width: 150px; height: 150px; ">
                    <h3>Questões</h3>
                    <canvas id="performance-total-graph" width="150" height="150" style="width: 150px; height: 150px;" ></canvas>
                </div>
            </div>
            <!-- <div width="150" height="150" style="width: 150px; height: 150px;"> -->
            <div class="col-md-6" style="text-align:center" >
                <div class="container" style="width: 150px; height: 150px;">
                    <h3>Acertos</h3>
                    <canvas id="performance-rights-graph" width="150" height="150" style="width: 150px; height: 150px;" ></canvas>
                </div>
            </div>

        </div>
    <br/>
    <div class="row" style="padding:15px;">

        <div class="col-md-6" style="text-align:center">
            <div class="container" style="width: 150px; height: 150px;">
                <h3>Tempo</h3>
                <canvas id="performance-time-graph" width="150" height="150" style="width: 150px; height: 150px;" ></canvas>
            </div>
        </div>


        <div class="col-md-6" style="text-align:center">

            <div class="container" style="width: 150px; height: 150px;">
                <h3>Tempo/Questão</h3>
                <canvas id="performance-average-time-graph" width="150" height="150" style="width: 150px; height: 150px;" ></canvas>
            </div>
        </div>

    </div>
    <br/>
            <!--</div> -->



    @endif



    <br/>
    @if (count($exam->courses) && $next == null)
        <div class="container no-padding p-bj" style="padding:15px;">
            <h3>MELHORE O SEU DESEMPENHO</h3>
            <div id="recomendados" class="tab-pane no-padding" style="margin:0px 0px 30px;padding:0;" >
                <div class="row no-padding "  style="padding:15px;">
                    @foreach($exam->courses as $course)
                        <div class=" no-padding p-bj-course  col-md-3 col-xs-6 ">
                            <article class="card-course with-border">
                                <!-- Início do Título Card do Curso -->
                                <a href="{{ route('course-section', [$course->slug]) }}" title="{{ $course->title }}">
                                    <div class="card-course-title-container">

                                        <h3 class="card-course-title"  style="background-color: {{ $course->subsection->section->color }}">
                                            {{ $course->title }}
                                        </h3>

                                    </div>
                                </a>
                                <!-- Fim do Título Card do Curso -->

                                <!-- Início do Conteúdo Card do Curso -->
                                <div class="card-course-content">
                                    @if ($course->final_price == 0.00)
                                        <span class="meta-value">&nbsp;</span>
                                        <span class="meta-value-promo"><strong style="color:{{ $course->subsection->section->color }};">GRATUITO</strong></span>
                                    @else
                                        @if($course->price !=  $course->discount_price)
                                            <span class="meta-value">De R$ {{ number_format($course->price, 2, ',', '.') }}</span>
                                            <span class="meta-value-promo">Por <strong style="color:{{ $course->subsection->section->color }};">R$ {{ number_format($course->final_price, 2, ',', '.') }}</strong></span>
                                        @else
                                            <span class="meta-value">&nbsp;</span>
                                            <span class="meta-value-promo">Por <strong style="color:{{ $course->subsection->section->color }};">R$ {{ number_format($course->final_price, 2, ',', '.') }}</strong></span>
                                        @endif
                                    @endif
                                    <small>Até 10x sem juros</small>
                                    <div class="clearfix height-10"></div>
                                    <a href="{{ route('cart.fast_purchase', [$course->id]) }}" class="pull-left btn-buy-now-card"><i class="fa fa-shopping-cart" style="color: {{ $course->subsection->section->color }}"></i> Compra Rápida</a>
                                    <a href="{{ route('course-section', [$course->slug]) }}" class="pull-right btn-plus-article" style="color: {{ $course->subsection->section->color }}"><i class="fa fa-plus-square-o"></i></a>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Início do Conteúdo Card do Curso -->
                            </article>
                        </div>

                    @endforeach


                </div>
            </div>
        </div>
    @endif

    @if($next == null)

        <a href="{{ Route('frontend.exams') }}" class="mb-xs mt-xs mr-xs btn btn-primary" style="margin:0px 15px; font-size: 2rem;">Retornar aos meus SAAP's</a>

    @endif

</div>