@extends('frontend.layouts.master')

<?php
$meta_description = "";
$meta_title = "";
if (isset($course->meta_description) && !empty($course->meta_description)) {
    $meta_description = $course->meta_description;
} else {
    $meta_description = substr(strip_tags($course->description), 0, 250);
}
if (isset($course->meta_title) && !empty($course->meta_title)) {
    $meta_title = $course->meta_title;
} else {
    $meta_title = substr(strip_tags($course->title), 0, 250);
}
?>

@section('meta-description', $meta_description)

@section('meta-title', $meta_title)

@section('title')
{{ $course->title }} | {{app_name()}}
@endsection



@section('subtopbar')

<div style="border-top: 1px solid rgba(0, 0, 0, 0.10); width: 100%">
    <div class="container">
        <div id="package-presentation" class="navbar-header">
            <div>
                <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>

                <h1 style="line-height: 0.8"> {{ $course->title }}</h1>
            </div>

        </div>
    </div>
</div>
@endsection


@section('content')
<section id="main-content">
    <div class="container">
        <h1 class="section-title"> {{ $course->title }}</h1>
        <div class="row" id="course">
            <div class="col-sm-3 no-padding p-bj">
                <div id="course-info">
                    <div class="card-course no-padding">
                        <div class="card-course-title-container">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" style="max-width:100%;height:auto;" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="{{ $course->title }}" />
                            </div>
                        </div>
                    </div>
                    <div id="course-body">

                        <div class="list-group">
                            <button type="button" class="list-group-item" data-toggle="modal" data-target="#termsUses"><i class="fa fa-exclamation-circle"></i> Termos de Uso</button>
                            <button type="button" class="list-group-item" data-toggle="modal" data-target="#requisites"><i class="fa fa-exclamation-circle"></i> Requisitos Minímos
                            </button>
                        </div>

                        <ul class="list-group">
                            @if($course->beginOfCourse != null)
                            <li class="list-group-item">
                                <i class="glyphicon glyphicon-road"></i>
                                IN&IacuteCIO: <b>{{ $course->beginOfCourse }}</b>
                            </li>
                            @endif
                            <li class="list-group-item">
                                <i class="fa fa-calendar"></i>
                                Tempo de acesso: <b>{{ $course->access_time }} dias</b>
                            </li>
                            @if (($course->workload_presential != null) && ($course->workload_presential != 0))
                            <li class="list-group-item">
                                <i class="fa fa-clock-o"></i>
                                Carga H. Presencial: <b>{{ format_display_time($course->workload_presential * 3600, true) }}</b>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-clock-o"></i>
                                Carga H. Online: <b>{{ $course->workload == 0 ? 'A definir' : number_format($course->workload * 3600, true) }}</b>
                            </li>
                            @else
                            @if (($course->workload != null) && ($course->workload != 0))
                            <li class="list-group-item">
                                <i class="fa fa-clock-o"></i>
                                Carga Horária: <b>{{ format_display_time($course->workload * 3600, true) }}</b>
                            </li>
                            @endif
                            @endif
                            <li class="list-group-item">
                                <i class="fa fa-eye"></i>
                                Visualizações por bloco{{ (($course->workload_presential != null) && ($course->workload_presential != 0)) ? " das aulas online" : "" }}: <b>{{ $course->max_view }}</b>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-clock-o"></i>
                                Por bloco{{ (($course->workload_presential != null) && ($course->workload_presential != 0)) ? " das aulas online" : "" }}:
                                <b>
                                    @if (($course->time_per_content != null) && ($course->time_per_content != ''))
                                    {!! $course->time_per_content !!}
                                    @else
                                    aprox. 30 min.
                                    @endif
                                </b>
                            </li>
                        </ul>

                    </div>
                </div>

                <div class="esconde-Botoes">
                    <ul class="list-group">
                        <li class="list-group-item course-price" style="text-align: center;">
                            @if ($course->final_price == 0.00)
                            <strong  class="label label-success">GRATUITO</strong>
                            @else
                            @if($course->price != $course->final_price)
                        <strike>R$ {{ number_format($course->price, 2, ',', '.') }}</strike>
                        <br/>
                        <br/>
                        @endif
                        @endif
                        <h1>R$ {{ number_format($course->final_price, 2, ',', '.') }}</h1>
                        {{--@if ($course->id == 453)--}}
                        {{--<br/>--}}
                        {{--<br/>--}}
                        {{--<span style="color: red;">Desconto válido para os 100 primeiros matriculados.</span>--}}
                        {{--@endif--}}
                        </li>
                        <li class="list-group-item" style="padding:0">
                            <a href="{{ route('cart.add', [$course->id, 'course']) }}" class="btn btn-success course-button" style="width:100%;height:100%;  font-size: 18px; font-color: white;  border:0; ">
                                @if ($course->final_price == 0.00)
                                ACESSE AGORA
                                @else
                                COMPRAR CURSO
                                @endif
                            </a>
                        </li>

                        @if($course->id == 550 || $course->id == 551 )
                        <li class="list-group-item" style="padding: 0; margin-top: 10px;">
                            <a data-toggle="modal" data-target="#addUser" href="#" class="btn btn-success course-button" style="background: #ff8415; width:100%;height:100%; font-size: 18px; font-color: white;  border:0;">
                                <strong>TESTE GRATUITAMENTE</strong>
                            </a>
                        </li>
                        @endif

                        <li class="list-group-item" style="padding: 0; margin-top: 10px;">
                            <a href="#" class="btn btn-success tell-a-friend-button" data-title="{{ $course->title }}" data-id="{{ $course->id }}" data-type="curso" style="background: #3b5998; width:100%; font-size: 18px; font-color: white;  border:0;">
                                <strong style="font-weight: normal;">INDIQUE UM AMIGO</strong>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
            <div style="position:relative;">

                <hr class="visible-xs visible-sm">


                <div class="col-sm-6">

                    <div data-example-id="togglable-tabs">

                        <div class="world-nav cat-menu " style="right: initial; top: initial; position:initial">
                            <ul class="list-inline big-cat">
                                <li class="active">
                                    <a href="#curso" id="curso-tab" role="tab" data-toggle="tab" aria-controls="video" aria-expanded="false">O Curso</a>
                                </li>
                                @if (($course->course_content != null) && ($course->course_content != ''))
                                <li>
                                    <a href="#conteudo" role="tab" id="conteudo-tab" data-toggle="tab" aria-controls="conteudo">Conteúdo</a>
                                </li>
                                @endif
                                @if (($course->methodology != null) && ($course->methodology != ''))
                                <li >
                                    <a href="#metodologia" role="tab" id="metodologia-tab" data-toggle="tab" aria-controls="metodologia">Metodologia</a>
                                </li>
                                @endif
                                @if (($course->testimonials != null) && ($course->testimonials != ''))
                                <li >
                                    <a href="#depoimentos" role="tab" id="depoimentos-tab" data-toggle="tab" aria-controls="depoimentos">Depoimentos</a>
                                </li>
                                @endif
                                @if (($course->workload_presential == null) || ($course->workload_presential == 0))
                                @if (count($course->modules) > 1)
                                <li >
                                    <a href="#disciplinas" role="tab" id="disciplinas-tab" data-toggle="tab" aria-controls="disciplinas">Disciplinas</a>
                                </li>
                                @endif
                                @endif
                                <li >
                                    <a href="#docentes" id="docentes-tab" role="tab" data-toggle="tab" aria-controls="docentes" aria-expanded="false">Docentes</a>
                                </li>
                            </ul>
                            <br/>
                        </div>




                    </div>


                    <div id="course-tabs-content" class="tab-content">
                        <script src="/js/selo.js"></script>
                        <div role="tabpanel" class="tab-pane fade active in" id="curso" aria-labelledby="curso">
                            <div id="course-teachers">
                                @if(!empty($course->video_ad_url))
                                @if($course->video_frag->vendor == 'youtube')
                                <iframe width="100%" height="400"
                                        src="https://www.youtube.com/embed/{{ $course->video_frag->id }}">
                                </iframe>
                                @endif
                                @if($course->video_frag->vendor == 'vimeo')
                                <iframe src="https://player.vimeo.com/video/{{ $course->video_frag->id }}?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                                        width="100%"  frameborder="0"  height="400"
                                        webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                                </iframe>
                                @endif
                                <!--p>Link: <a href="{{ $course->video_ad_url }}">{{ $course->video_ad_url }}</a></p-->
                                @endif
                            </div>

                            <p>{!! $course->description !!}</p>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="docentes" aria-labelledby="docentes" >
                            <div id="course-teachers" >
                                <section class="section professor">
                                    <div class="row">
                                        @foreach($course->teachers as $index => $teacher)

                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="entry-header">
                                                    <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location ='{{ route("teachers.show", [$teacher->teacher->idOrSlug()]) }}'">
                                                        <a href="{{ route("teachers.show", [$teacher->teacher->idOrSlug()]) }}"><img class="img-responsive" src="{{ imageurl('users/', $teacher->teacher->id, $teacher->teacher->photo, 200, 'generic.png',true) }}" alt="" /></a>
                                                    </div>
                                                </div>
                                                <div class="post-content">
                                                    <h2>
                                                        <a href="{{ route("teachers.show", [$teacher->teacher->idOrSlug()]) }}" >{{ $teacher->teacher->name }}</a>
                                                    </h2>
                                                    <div class="entry-content">
                                                        <p>{{ str_limit($teacher->teacher->resume, 300) }}</p>
                                                    </div>
                                                </div>
                                            </div><!--/.card-->
                                        </div><!--/.col-->

                                        @endforeach
                                    </div>
                                </section>
                            </div>
                        </div>

                        @if (($course->methodology != null) && ($course->methodology != ''))
                        <div class="tab-pane fade" id="metodologia" aria-labelledby="metodologia">
                            <p>{!! $course->methodology !!}</p>
                        </div>
                        @endif

                        @if (($course->testimonials != null) && ($course->testimonials != ''))
                        <div class="tab-pane fade" id="depoimentos" aria-labelledby="depoimentos">
                            <p>{!! $course->testimonials !!}</p>
                        </div>
                        @endif
                        <div class="tab-pane fade" id="disciplinas" aria-labelledby="disciplinas">
                            <div class="panel-group" id="faq-page" role="tablist" aria-multiselectable="true">
                                @foreach($course->modules as $module)
                                <div>
                                    <div  role="tab" id="headingOne">

                                        <div class="row">

                                            @foreach($module->teachers as $objTeacher)
                                            <!--                                            <div class="col-sm-4 col-xs-6" style="margin-top: -20px;">
                                                                                    <div class="post feature-post">
                                                                                        <div class="entry-thumbnail">
                                                                                            <img class="img-responsive" src="{{ imageurl('users/', $objTeacher->id, $objTeacher->photo, 200, 'generic.png',true) }}" alt="" />
                                                                                        </div>
                                                                                        <div class="post-content2">
                                                                                            <h2 class="entry-title">
                                                                                                <a href="{{ route("teachers.show", [$objTeacher->id]) }}">{{ $objTeacher->name }}</a>
                                                                                            </h2>
                                                                                        </div>
                                                                                    </div>/post
                                                                                    
                                                                                </div>/.col-->

                                            <div class="col-sm-12">
                                                <div class="col-sm-6"><strong>{{ $module->name }}</strong></div>
                                                <div class="col-sm-6">{{ $objTeacher->name }} </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="conteudo" aria-labelledy="conteudo">
                            {{--<h4><strong>DIREITO CONSTITUCIONAL - 17 AULAS</strong></h4>--}}
                            {!! $course->course_content !!}
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-3" >
                <div class="course-panel">
                    <ul class="list-group" id="botoes-desktop" >

                        @if ($course->final_price == 0.00)
                        <li class="list-group-item course-price" style="text-align: center; bottom: 10px;">
                            <h1><strong>GRATUITO</strong></h1>
                        </li>
                        @else

                        <li class="list-group-item course-price" style="text-align: center; bottom: 10px;" >
                            @if ($course->max_installments > 1)
                            @if($course->price != $course->final_price)
                            De: <strike>R$ {{ number_format($course->price, 2, ',', '.') }}</strike>
                        <br/>
                        Por:
                        <br/>
                        @endif
                        <div class="col-md-30 row" style="text-align: center;margin-left: 8px;">
                            <div class="col-md-2" style="text-align: center;" ><h4>{{$course->max_installments}}x</h4></div>
                            <div class="col-md-10" style="padding-left: 0px;padding-right: 0px;"><h1 style="text-align: left;">R$ {{ number_format($course->final_price/$course->max_installments, 2, ',', '.') }}</h1></div>
                            <br><br><br>
                        </div>
                        <div class="row" style="text-align: right;margin-right: 0px;" >
                            Total: R$ {{ number_format($course->final_price, 2, ',', '.') }} <i class="fa fa-credit-card"></i>
                        </div>
                        @else
                        @if($course->price != $course->final_price)
                        De: <strike>R$ {{ number_format($course->price, 2, ',', '.') }}</strike>
                        <br/>
                        Por:    
                        <br/>
                        @endif
                        <h1>R$ {{ number_format($course->final_price, 2, ',', '.') }}</h1>


                        À Vista

                        @endif

                        </li>
                        <li class="list-group-item" style="margin-bottom: 10px;">
                            8% de desconto no pagamento à vista (no boleto a partir de R$ 120,00).
                        </li>

                        @endif

                        <li class="list-group-item" style="padding:0" >
                            <a href="{{ route('cart.add', [$course->id, 'course']) }}" class="btn btn-success course-button" style="width:100%;height:100%; padding: 20px; font-size: 18px; font-color: white;  border:0; ">
                                @if ($course->final_price == 0.00)
                                ACESSE AGORA
                                @else
                                COMPRAR CURSO
                                @endif
                            </a>
                        </li>

                        @if( @$course->id == 550 || @$course->id == 551)
                        @if(Auth::guest())
                        <li class="list-group-item" style="padding: 0; margin-top: 10px;">
                            <a data-toggle="modal" data-target="#addUser" href="#" class="btn btn-success course-button" style="background: #ff8415; width:100%;height:100%; padding: 20px; font-size: 18px; font-color: white;  border:0;">
                                <strong>TESTE GRATUITAMENTE</strong>
                            </a>
                        </li>
                        @else
                        <li class="list-group-item" style="padding: 0; margin-top: 10px;" teste="{{$_SERVER["REQUEST_URI"]}}">
                            <a href="/auth/retafinal" class="btn btn-success course-button" style="background: #ff8415; width:100%;height:100%; padding: 20px; font-size: 18px; font-color: white;  border:0;">
                                <strong>TESTE GRATUITAMENTE</strong>
                            </a>
                        </li>
                        @endif
                        @endif

                        <li class="list-group-item" style="padding: 0; margin-top: 10px;">
                            <a href="#" class="btn btn-success tell-a-friend-button" data-title="{{ $course->title }}" data-id="{{ $course->id }}" data-type="curso" style="background: #3b5998; width:100%; padding: 20px; font-size: 18px; font-color: white;  border:0;">
                                <strong style="font-weight: normal;">INDIQUE AOS AMIGOS</strong>
                            </a>
                        </li>
                    </ul>
                    @if (count($relatedcourses))
                        @foreach($relatedcourses as $course_related)
                            <div class="post feature-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail">
                                        <a href="/cursinhos/{{ $course_related->section_slug}}/{{ $course_related->slug }}"><img class="img-responsive" src="{{ imageurl("courses/", $course_related->id , $course_related->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                    </div>
                                </div>
                                <div class="post-content2">
                                    <h2 class="entry-title">
                                        <a href="/cursinhos/{{ $course_related->section_slug }}/{{ $course_related->slug }}">R$ {{ number_format(getFinalPrice($course_related), 2, ',', '.') }} </a>
                                    </h2>
                                </div>
                            </div><!--/post-->
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal for course id 550-->
@if($course->id == 550 || $course->id == 551)
<!-- Modal Reta Final-->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div id="tabs-content" class="tab-content">
                <section id="content-export" class="panel">
                    <div class="panel-body" style='height: 100%;'>
                        <div class="col-sm-6" style="padding-left: 0; padding-right: 0; margin-top: 60px;">
                            <img src="/img/frontend/modal_reta_final.png" width="100%">
                        </div>
                        <div class="col-sm-6">
                            <div class="ragister-account account-login" style="padding-top: 0 !important;padding-bottom: 5px;margin-bottom: 0px;">
                                <h1 class="section-title title">Acesse Agora</h1>
                                <div class="login-options text-center">
                                    <a style="width: 79%;" href="/auth/login/facebook" class="facebook-login"><i class="fa fa-facebook"></i> Login com Facebook</a>
                                </div>

                                {!! Form::open(['url' => 'auth/register', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                <div class="form-group">
                                    {!! Form::label('name', trans('validation.attributes.name-and-surname'), []) !!}
                                    {!! Form::input('name', 'name', old('name'), ['class' => 'form-control']) !!}

                                </div>
                                <div class="form-group">
                                    {!! Form::label('email', trans('validation.attributes.email'), []) !!}
                                    {!! Form::input('email', 'email', old('email'), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6" style="padding-left: 0; padding-right: 5px">
                                        {!! Form::label('password', trans('validation.attributes.password'), []) !!}
                                        {!! Form::input('password', 'password', old('password'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-sm-6" style="padding-left: 0; padding-right: 0">
                                        {!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), []) !!}
                                        {!! Form::input('password', 'password_confirmation', old('password_confirmation'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label class="pull-left" for="signing"><input name="signing" id="signing" value="1" type="checkbox"> Li e aceito os <a style="color: #1b2f62; font-weight: bold;" href="#" data-toggle="modal" data-target="#termsUses">Termos de Uso</a> </label>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6" style="width: 40%;">
                                        <input style="" class="btn btn-primary" value="Entrar" type="submit">
                                    </div>
                                    <div class="col-sm-6" style="width: 60%; ">
                                        <style type="text/css">
                                            .btn:hover{
                                                color: white !important;
                                            }
                                        </style>
                                        <a href="/auth/login" style="width: 100%; padding-left: 20%;" class="btn btn-primary">
                                            Já sou Cadastrado
                                        </a>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Reta Final-->
@endif


<!-- Modal -->
<div class="modal fade" id="termsUses" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Termos de Uso</h4>
            </div>
            <div class="modal-body">
                @include('frontend.institutional.terms-content')
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="requisites" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <strong>Desktops e notebooks</strong><br/>
                Largura de banda mínima de 2Mbps<br/>
                Resolução mínima de 1024 x 768 pixels<br/>
                Versão mais atual do do Flash Player<br/>
                Última versão dos principais Navegadores: Internet Explorer, Mozilla Firefox, Google Chrome e Safari<br/>
                <br/>
                <strong>iPad e iPhone</strong><br/>
                Conexão WiFi<br/>
                Largura de banda mínima de 2Mbps<br/>
                iOS 7 ou superior<br/>
                <br/>
                <strong>Smartphones e tablets Android</strong><br/>
                Conexão WiFi<br/>
                Largura de banda mínima de 2Mbps<br/>
                Android 4.4 ou superior<br/>
                <br/>
                <strong>Smart TVs</strong><br/>
                Conexão WiFi<br/>
                Largura de banda mínima de 2Mbps<br/>
                Navegadores Compatíveis<br/>
            </div>

        </div>
    </div>
</div>


@endsection

@section('after-scripts-end')
<script>
    !function (f, b, e, v, n, t, s) {
        if (f.fbq)
            return;
        n = f.fbq = function () {
            n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq)
            f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window,
            document, 'script', '//connect.facebook.net/en_US/fbevents.js');
    fbq('track', 'ViewContent');


</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1576695232624762&ev=PageView&noscript=1"/></noscript>

@stop
