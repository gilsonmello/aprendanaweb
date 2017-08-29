

<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="suggestionModalLabel" style="color: #08C">Cursos que abordam {{ $subject->name }}</h4>
            </div>
            <div class="modal-body">
                <div class="container no-padding p-bj" style="padding:15px;">
                    <div id="temas-recomendados" class="tab-pane no-padding" style="margin:0px 0px 30px;padding:0;" >
                        <div class="row no-padding "  style="padding:15px;">
                            @foreach($subject->courses as $course)
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
            </div>
        </div>
    </div>