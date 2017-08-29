@extends('frontend.layouts.master')

@section('content')

    <section id="slider-home" class="slider" style="overflow:hidden;max-height:320px;">
       <ul class="slides">
           @foreach($sliders as $slider)
               <li class="section slider-{!! ($slider->orientation == 'L' ? 'left' : ($slider->orientation == 'R' ? 'right' : 'middle' ) )!!}" style="background-image:url('/uploads/sliders/{{ $slider->id }}/{{ $slider->img }}');height:340px;"><a class="slider-link" href="{{ $slider->url }}"></a></li>
           @endforeach
       </ul>
   </section>

   <div id="dl-menu" class="col-md-12 dl-menuwrapper blue-bj hidden-lg  p-10" style="z-index:200;">
       <a href="#" class="dl-trigger anchor" style="color:#FFF;text-transform:uppercase;text-decoration:none;"><i class="fa fa-bars"></i> &nbsp; Cursos Online do Brasil Jurídico</a>
       <ul class="dl-menu ">
           @foreach($sections as $section)
           <li style="background: {{ $section->color }}!important">
               <a href="#">{{ $section->name }}</a>

               <ul class="dl-submenu" style="background: {{ $section->color }}!important">
               @foreach($section->courses(6) as $course)
                   <li>
                       <a href="{{ route('course-section', [$course->slug]) }}">{{ $course->title }}</a>

                   </li>
               @endforeach
               </ul>
           </li>
           @endforeach
       </ul>
   </div>

   @include('frontend.includes.menu-home')

   <!-- ads cursos -->
   <section id="ads">
       <div class="container no-padding">
           <div clas="row no-padding">
               <div class="ads-list" style="margin-bottom: 50px;margin-top: 30px;">

                   <?php $count = 1; ?>
                   @foreach($coursesFeatured as $course)
                       @if ($count % 2 == 1) <div class="no-padding"> @endif
                       <article class="card-ads">
                           <a href="{{ route('course-section', [$course->slug]) }}" title="" class="yellow-bj card">
                               <img src="{{ imageurl("courses/", $course->id, $course->featured_img, 400, 'course_home.jpg') }}" class="img-responsive">
                               <div class="card-content" style="background: {{ $course->subsection->section->color }}!important">
                                   <h3>{{ $course->title }}</h3>
                               </div>
                           </a>
                       </article>
                       @if ($count % 2 == 0) </div> @endif
                       <?php $count++; ?>
                   @endforeach

                   @if($count % 4 != 1) </div> @endif

               </div>
           </div>
       </div>
   </section>

   <!-- tabs cursos -->
   <div class="grey" style="padding-bottom:30px;">
       <div class="container">
           <div>
           <div class="row">
               <!-- Navegação dos Tabs da Home -->
               <ul class="nav p-bj" role="tablist" id="nav-secondary-home">
                   <li class="col-md-3 col-xs-3 no-padding"><a href="#destaques" aria-controls="destaques" role="tab" data-toggle="tab">Novos</a></li>
                   <li class="col-md-3 col-xs-3 no-padding active"><a href="#promocoes" aria-controls="promocoes" role="tab" data-toggle="tab">Promoções</a></li>
                   <li class="col-md-3 col-xs-3 no-padding"><a href="#recomendados" aria-controls="recomendados" role="tab" data-toggle="tab">Top 8</a></li>
                   <li class="col-md-3 col-xs-3 no-padding"><a href="#maisvendidos" aria-controls="maisvendidos" role="tab" data-toggle="tab">+Vendidos</a></li>
               </ul>
           </div>
               <!-- Navegação dos Tabs da Home -->
               <!-- Content dos Tabs -->
               <div class="height-25"></div>
               <div class="tab-content" id="courses-master">
                   <div role="tabpanel" class="tab-pane no-padding fade" id="destaques" style="padding:0;margin:0;">
                       <div class="row no-padding">
                       <?php $count = 1; ?>
                       @foreach($coursesRelease as $course)
                           <!-- Início do Card do Curso -->
                           @if ($count % 2 == 1)<div class="no-padding">@endif
                           <div class="p-bj-course">
                           <article class="card-course">
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
                                   @if ($course->price == 0.00)
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
                                       <a href="{{ route('cart.fast_purchase', [$course->id, 'course']) }}" class="pull-left btn-buy-now-card"><i class="fa fa-shopping-cart" style="color: {{ $course->subsection->section->color }}"></i> Compra Rápida</a>
                                       <a href="{{ route('course-section', [$course->slug]) }}" class="pull-right btn-plus-article" style="color: {{ $course->subsection->section->color }}"><i class="fa fa-plus-square-o"></i></a>
                                       <div class="clearfix"></div>
                                   </div>
                                   <!-- Início do Conteúdo Card do Curso -->
                           </article>
                           </div>
                           @if ($count % 2 == 0) </div> @endif
                           <?php $count++; ?>

                           <!-- Fim do Card do Curso -->
                       @endforeach
                       @if($count % 4 != 1) </div> @endif
                       </div>
                   </div>

                   <div id="promocoes" class="tab-pane fade no-padding in active" style="margin:0;padding:0;">
                        <div class="row no-padding">
                       <?php $count = 1; ?>
                       @foreach($coursesSpecialOffer as $course)
                           <!-- Início do Card do Curso -->
                           @if ($count % 2 == 1)<div class="no-padding">@endif
                           <div class="p-bj-course">
                           <article class="card-course">
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
                                   @if ($course->price == 0.00)
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
                                       <a href="{{ route('cart.fast_purchase', [$course->id, 'course']) }}" class="pull-left btn-buy-now-card"><i class="fa fa-shopping-cart" style="color: {{ $course->subsection->section->color }}"></i> Compra Rápida</a>
                                       <a href="{{ route('course-section', [$course->slug]) }}" class="pull-right btn-plus-article" style="color: {{ $course->subsection->section->color }}"><i class="fa fa-plus-square-o"></i></a>
                                       <div class="clearfix"></div>
                                   </div>
                                   <!-- Início do Conteúdo Card do Curso -->
                           </article>
                           </div>
                           @if ($count % 2 == 0) </div> @endif
                           <?php $count++; ?>

                           <!-- Fim do Card do Curso -->
                       @endforeach
                       @if($count % 4 != 1) </div> @endif
                       </div>
                   </div>

                   <div id="recomendados" class="tab-pane fade no-padding" style="margin:0;padding:0;">
                       <div class="row no-padding">
                       <?php $count = 1; ?>
                       @foreach($coursesRecommended as $course)
                           <!-- Início do Card do Curso -->
                           @if ($count % 2 == 1)<div class="no-padding">@endif
                           <div class="p-bj-course">
                           <article class="card-course">
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
                                   @if ($course->price == 0.00)
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
                                       <a href="{{ route('cart.fast_purchase', [$course->id, 'course']) }}" class="pull-left btn-buy-now-card"><i class="fa fa-shopping-cart" style="color: {{ $course->subsection->section->color }}"></i> Compra Rápida</a>
                                       <a href="{{ route('course-section', [$course->slug]) }}" class="pull-right btn-plus-article" style="color: {{ $course->subsection->section->color }}"><i class="fa fa-plus-square-o"></i></a>
                                       <div class="clearfix"></div>
                                   </div>
                                   <!-- Início do Conteúdo Card do Curso -->
                           </article>
                           </div>
                           @if ($count % 2 == 0) </div> @endif
                           <?php $count++; ?>

                           <!-- Fim do Card do Curso -->
                       @endforeach
                       @if($count % 4 != 1) </div> @endif
                       </div>
                   </div>

                   <div id="maisvendidos" class="tab-pane fade" class="tab-pane fade no-padding" style="margin:0;padding:0;">
                       <div class="row no-padding">
                       <?php $count = 1; ?>
                       @foreach($coursesBestSelling as $course)
                           <!-- Início do Card do Curso -->
                           @if ($count % 2 == 1)<div class="no-padding">@endif
                           <div class="p-bj-course">
                           <article class="card-course">
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
                                       @if ($course->price == 0.00)
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
                                       <a href="{{ route('cart.fast_purchase', [$course->id, 'course']) }}" class="pull-left btn-buy-now-card"><i class="fa fa-shopping-cart" style="color: {{ $course->subsection->section->color }}"></i> Compra Rápida</a>
                                       <a href="{{ route('course-section', [$course->slug]) }}" class="pull-right btn-plus-article" style="color: {{ $course->subsection->section->color }}"><i class="fa fa-plus-square-o"></i></a>
                                       <div class="clearfix"></div>
                                   </div>
                                   <!-- Início do Conteúdo Card do Curso -->
                           </article>
                           </div>
                           @if ($count % 2 == 0) </div> @endif
                           <?php $count++; ?>

                           <!-- Fim do Card do Curso -->
                       @endforeach
                       @if($count % 4 != 1) </div> @endif
                       </div>
                   </div>
               </div>
           </div>
           <div class="height-25"></div>
           <div class="clearfix"></div>
       </div>
   </div>
   <!-- ./tabs cursos -->

   <div class="container p-bj no-padding"><a id="all-courses-bj" class="" href="{{ Route('courses') }}">Ver Todos os Cursos do Brasil Jurídico</a></div>

   <!-- curta juridico -->
   <section id="noticias-destaque">
       <div class="container no-padding">
           <h3 class="title-home">Curta Jurídico</h3>
           <div id="destaques-list" >

               @foreach($videos as $video)
               <article class="card-notice blue-text">
                   <a href="{{ route("videos.show", [$video->slug]) }}">
                       <img src="/uploads/videos/{!! $video->id !!}/{!! $video->img !!}" class="img-responsive">
                       <div class="p-15">
                           <h4>{{ $video->title }}</h4>
                           <a href="{{ route("videos.show", [$video->slug]) }}" class="new-plus pull-right">Assista</a>
                           <div class="clearfix"></div>
                       </div>

                   </a>
                   <div class="clearfix"></div>
               </article>

               @endforeach
               </div>
       </div>
   </section>
   <!-- ./curta juridico -->

   <!-- professores -->
   <div class="grey padding-grey">
       <section id="professores-bj">
           <div class="container no-padding">
               <h4 class="title-home">Professores Associados</h4>
               <div id="professores-bj-list">

                   @foreach($teachers as $teacher)
                   <article class="card-ads card-prof">
                       <a href="{{ route("teachers.show", [$teacher->id]) }}" title="" class="red-bj card">
                           <img src="{{ imageurl("users/", $teacher->id, $teacher->photo, 100, 'genericsolid.jpg', 1) }}" class="img-responsive">
                           {{ $teacher->img_sizes[400] }}
                           <div class="card-content red-bj">
                               <h3>{{ $teacher->name }}</h3>
                           </div>
                       </a>
                   </article>
                   @endforeach

               </div>
           </div>
       </section>
   </div>
   <!-- ./professores -->


   <!-- artigos -->
   <section id="articles">
       <div class="container no-padding">
           <h3 class="title-home">Artigos</h3>
           <div id="articles-list">
           @foreach($articles as $article)
               <div class="p-bj-course height-100">
               <a href="{{ route("articles.show", [$article->slug]) }}" class="article-link">
               <article class="card-article height-100">

                   <h4 class="card-article-title">{{ str_limit($article->title, 150) }}</h4>
                   <hr class="line-card-article">
                   <span class="card-article-author">Por {!!  $article->users()->first()->name !!}</span>
                   <a href="{{ route("articles.show", [$article->slug]) }}" class="new-plus pull-right">Leia Mais</a>

               </article>
               </a>
               </div>
               @endforeach
           </div>
       </div>
   </section>
   <!-- ./artigos -->


   <!-- noticias -->
   <section id="noticias-destaque" class="notices-home">
       <div class="container no-padding">
           <h3 class="title-home">Notícias</h3>
           <div id="news-list" >
               @foreach($news as $new)
               <article class="card-notice blue-text">
                   <a href="{{ route("news.show", [$new->slug]) }}">
                       <!--img src="/uploads/videos/{!! $new->id !!}/{!! $new->img !!}" class="img-responsive"-->
                       <div class="p-15">
                           <h4>{{ $new->title }}</h4>
                           <a href="{{ route("news.show", [$new->slug]) }}" class="new-plus pull-right">Leia Mais</a>
                           <div class="clearfix"></div>
                       </div>

                   </a>
                   <div class="clearfix"></div>
               </article>
               @endforeach
           </div>
       </div>
   </section>
   <!-- ./artigos -->

   <!-- newsletter -->
   <section id="newsletter">
       <div class="container no-padding">
           {!! Form::open(array('route' => array('newsletters.subscribe'), 'method' => 'post'))  !!}
               <div class="form-group col-md-4">
                   <input type="name" class="form-control" placeholder="Seu Nome" name="name">
               </div>
               <div class="form-group col-md-4">
                   <input type="email" class="form-control" placeholder="Seu E-mail" name="email">
               </div>
               <div class="col-xs-12 col-md-4">
                   <button type="submit" class="btn btn-danger col-md-4 col-xs-3">Enviar</button>

                   <label class="col-md-8 col-xs-9">Assine nossa Newsletter</label>
               </div>
           {!! Form::close() !!}
           <div class="clearfix"></div>
       </div>
   </section>
   <!-- ./newsletter -->


   <section id="pagseguro">
       <div class="container">
           <img src="http://brasiljuridico.com.br/img/rodape-pagseguro.png" class="img-responsive">
       </div>
   </section>

@endsection

@section('after-scripts-end')
	<script>
		//Being injected from FrontendController
	</script>
@stop