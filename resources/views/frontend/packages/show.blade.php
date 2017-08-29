@extends('frontend.layouts.master')

<?php
$meta_description = "";
$meta_title = "";
if (isset($package->meta_description) && !empty($package->meta_description)) {
    $meta_description = $package->meta_description;
} else {
    $meta_description = substr(strip_tags($package->description), 0, 250);
}
if (isset($package->meta_title) && !empty($package->meta_title)) {
    $meta_title = $package->meta_title;
} else {
    $meta_title = substr(strip_tags($package->title), 0, 250);
}
?>

@section('meta-description', $meta_description)

@section('meta-title', $meta_title)

@section('title')
{{ $package->title }} | {{app_name()}}
@endsection

<!-- Facebook Pixel Code -->
{{--<script>--}}
{{--!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?--}}
{{--n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;--}}
{{--n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;--}}
{{--t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,--}}
{{--document,'script','//connect.facebook.net/en_US/fbevents.js');--}}
{{--fbq('track', "ViewContent");--}}
{{--</script>--}}
{{--<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=973245029429675&ev=PageView&noscript=1"/></noscript>--}}
<!-- End Facebook Pixel Code -->
@section('subtopbar')

<div style="border-top: 1px solid rgba(0, 0, 0, 0.10); width: 100%">
    <div class="container">
        <div id="package-presentation" class="navbar-header">
            <div>
                <h1> {{ $package->title }}</h1>
            </div>

        </div>
    </div>
</div>

@endsection

@section('content')

<section id="main-content">


    @if ($package->id !== 56)
    @include('frontend.includes.exams-discount')
    @endif

    <div class="space small"></div>
    <div class="container">

        <h1 class="section-title"> {{ $package->title }}</h1>
        <div class="row" id="course">
            <div class="col-sm-9 p-bj" style="padding-left: 30px;">
                <div class="row">
                    <div id="course-info">
                        <div id="course-body">

                            <div class="list-group">
                                <ul>

                                    <li class="list-group-item  col-sm-4">
                                        <i class="fa fa-calendar"></i>
                                        Tempo de acesso<br> <b>{{ $package->access_time }} dias</b>
                                    </li>
                                    @if($package->exams->count() === 1)
                                    <li class="list-group-item col-sm-4">
                                        <i class="fa fa-list-ol"></i>
                                        Questões<br> <b>{!! $package->exams[0]->exam->questions_count !!}</b>
                                    </li>
                                    <li class="list-group-item col-sm-4">
                                        <i class="fa fa-pencil-square-o"></i>
                                        Execuções<br> <b>{!! $package->exams[0]->exam->max_tries !!} vezes</b>
                                    </li>

                                    <li class="list-group-item col-sm-4">
                                        <i class="fa fa-clock-o"></i>
                                        Modo Prova<br> <b>{{ parse_duration_to_time_string($package->exams[0]->exam->duration) }}</b>
                                    </li>


                                    <li class="list-group-item col-sm-4">
                                        <i class="fa fa-clock-o"></i>
                                        Modo Comentado<br> <b>{{ parse_duration_to_time_string($package->exams[0]->exam->duration) }} {{($package->exams[0]->exam->video_time != null) && ($package->exams[0]->exam->video_time != 0) ? " + " .  $package->exams[0]->exam->questions_count . ' Vídeos/Audio' : "" }} </b>
                                    </li>
                                    <li class="list-group-item col-sm-4">
                                        <i class="fa fa-play"></i>
                                        {!! $package->exams[0]->exam->questions_count !!} Vídeos/Audio<br> <b>{{ parse_duration_to_time_string($package->exams[0]->exam->video_time) }}</b>
                                    </li>
                                    @else
                                    <li class="list-group-item col-sm-4">
                                        <a onclick="$('#disciplinas-tab').click()" role="tab" id="lista-saaps-tab" data-toggle="tab" aria-controls="disciplinas" style="cursor:pointer"><b>Os SAAP's deste pacote</b> </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="esconde-Botoes">
                                <li class="list-group-item" style="padding:0" teste="{{$_SERVER["REQUEST_URI"]}}">
                                    <a href="{{ route('cart.add', [$package->id, 'package']) }}" class="btn btn-success course-button" style="width:100%; padding: 20px; font-size: 18px; font-color: white;">
                                        @if ($package->final_price == 0.00)
                                        ACESSE AGORA
                                        @else
                                        COMPRAR
                                        @endif
                                    </a>
                                </li>
                            </div>


                            <div class='clearfix'></div>

                            <div class="space small"></div>

                            @if(!empty($package->video_ad_url))
                            <div id="course-teachers" >
                                @if($package->video_frag->vendor == 'youtube')
                                <iframe width="100%"  height="400"
                                        src="https://www.youtube.com/embed/{{ $package->video_frag->id }}">
                                </iframe>
                                @endif
                                @if($package->video_frag->vendor == 'vimeo')
                                <iframe src="https://player.vimeo.com/video/{{ $package->video_frag->id }}?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                                        width="100%" frameborder="0"  height="400"
                                        webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                                </iframe>
                                @endif
                            </div>
                            @endif

                            @if (($package->description != null) && ($package->description != ''))
                            <p>{!! trim($package->description) !!}</p>
                            @endif

                            <h2>Tutorial</h2>

                            <div id="package-tutorial">
                                <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/173817322" allowfullscreen></iframe>
                                </div>
                            </div>


                            <h2>Metodologia</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="noticiacard">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img class="img-responsive" src="/img/frontend/saap-inovador.png" alt="" />
                                            </div>
                                        </div>
                                        <div class="noticiacard-content">
                                            <h3 class="title">
                                                Inovador e completo
                                            </h3>
                                            <div class="entry-content">
                                                <p>Avaliação simulada com cronÃ´metro, comentarios a cada questão em vídeo, audio e textos, espaço para anotações, marcações diretamente na questão, gabarito analítico e relatório segmentado de desempenho.</p>
                                            </div>
                                        </div>
                                    </div><!--/post-->
                                </div>

                                <div class="col-md-6">
                                    <div class="noticiacard">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img class="img-responsive" src="/img/frontend/saap-360.png" alt="" />
                                            </div>
                                        </div>
                                        <div class="noticiacard-content">
                                            <h3 class="title">
                                                Analise 360°
                                            </h3>
                                            <div class="entry-content">
                                                <p>Analise completa e detalhada de cada concurso e exame da OAB, apresentando um estudo minucioso de todos os aspectos relevantes sobre as últimas provas.</p>
                                            </div>
                                        </div>
                                    </div><!--/post-->
                                </div>
                            </div>
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="noticiacard">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img class="img-responsive" src="/img/frontend/saap-otimizacao.png" alt="" />
                                            </div>
                                        </div>
                                        <div class="noticiacard-content">
                                            <h3 class="title">
                                                Otimização dos estudos
                                            </h3>
                                            <div class="entry-content">
                                                <p>Somente com treinamento é possível alcançar bons resultados. Por isso o SAAP oferece de maneira objetiva, contextualizada e eficiente, todos os mecanismos para potencializar seus estudos e desempenho.</p>
                                            </div>
                                        </div>
                                    </div><!--/post-->
                                </div>

                                <div class="col-md-6">
                                    <div class="noticiacard">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img class="img-responsive" src="/img/frontend/saap-avalie.png" alt="" />
                                            </div>
                                        </div>
                                        <div class="noticiacard-content">
                                            <h3 class="title">
                                                Avalie sua performance
                                            </h3>
                                            <div class="entry-content">
                                                <p>Saiba exatamente como esta sua performance através de relatórios completos de desempenho, que mostram ponto a ponto os erros e acertos correspondentes a cada tema.</p>
                                            </div>
                                        </div>
                                    </div><!--/post-->
                                </div>

                            </div>
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="noticiacard">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img class="img-responsive" src="/img/frontend/saap-orientado.png" alt="" />
                                            </div>
                                        </div>
                                        <div class="noticiacard-content">
                                            <h3 class="title">
                                                Conteúdo orientado ao resultado
                                            </h3>
                                            <div class="entry-content">
                                                <p>Indicação de legislação, jurisprudência, informativos, livros, e-books e principalmente cursos essenciais, com base nas suas estatísticas de desempenho.</p>
                                            </div>
                                        </div>
                                    </div><!--/post-->
                                </div><!--/.row-->

                                <div class="col-md-6">
                                    <div class="noticiacard">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img class="img-responsive" src="/img/frontend/saap-desempenho.png" alt="" />
                                            </div>
                                        </div>
                                        <div class="noticiacard-content">
                                            <h3 class="title">
                                                Alcance seu melhor desempenho
                                            </h3>
                                            <div class="entry-content">
                                                <p>Ferramentas desenvolvidas após analise criteriosa de todo o processo de estudo com sedimentação do conhecimento orientado a aferir e melhorar o seu desempenho a cada etapa do SAAP.</p>
                                            </div>
                                        </div>
                                    </div><!--/post-->
                                </div><!--/.row-->
                            </div><!--/.container-->


                            @if (count($package->exams) > 1)
                            <div class="panel-group" id="faq-page" role="tablist" aria-multiselectable="true" style="padding-top: 20px;">
                                @foreach($package->exams as $exam)
                                <div class="panel panel-default" style="padding: 20px;">
                                    <div  role="tab" id="headingOne">
                                        <h4 class="panel-title "  style="font-size: 2.0rem;">
                                            <strong>{{ $exam->exam->title }}</strong>
                                        </h4>
                                        <br>
                                        <i class="fa fa-list-ol"></i>
                                        Questões: <b>{!! $exam->exam->questions_count !!}</b>
                                        <br>
                                        <br>
                                        <i class="fa fa-pencil-square-o"></i>
                                        Execuções: <b>{!! $exam->exam->max_tries !!} vezes</b>
                                        <br>
                                        <br>
                                        <i class="fa fa-clock-o"></i>
                                        Tempo por execução: <b>{{ parse_duration_to_time_string($exam->exam->duration) }}</b>
                                        @if (($package->exams[0]->exam->video_time != null) && ($package->exams[0]->exam->video_time != 0))
                                        <br>
                                        <br>
                                        <i class="fa fa-play"></i>
                                        Total dos {!! $package->exams[0]->exam->questions_count !!} vídeos: <b>{{ parse_duration_to_time_string($package->exams[0]->exam->video_time) }} </b>
                                        @endif

                                    </div>

                                </div>
                                @endforeach
                            </div>
                            @endif

                            <div id="package-teachers" >
                                <section class="section professor">
                                    <div class="row">
                                        @foreach($package->teachers as $index => $teacher)
                                        <!--
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
                                                                                        </div>/.card
                                                                                    </div>/.col-->

                                        @endforeach
                                    </div>
                                </section>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-3" style="margin-top: 30px">
                <div class="course-panel">
                    <ul class="list-group">



                        @if ($package->final_price == 0.00)
                        <li class="list-group-item course-price" style="text-align: center; bottom: 10px;">
                            <h1><strong>GRATUITO</strong></h1>
                        </li>
                        @else

                        <li class="list-group-item course-price" style="text-align: center; bottom: 10px;" >

                            @if ($package->max_installments > 1)
                            <div class="col-md-30 row" style="text-align: center;margin-left: 8px;">
                                @if($package->price != $package->final_price)
                                De: <strike>R$ {{ number_format($package->price, 2, ',', '.') }}</strike>
                                <br/>
                                Por:
                                <br/>
                                @endif
                                <div class="col-md-2" style="text-align: center;" ><h4>{{$package->max_installments}}x</h4></div>
                                <div class="col-md-10" style="padding-left: 0px;padding-right: 0px;"><h1 style="text-align: left;">R$ {{ number_format($package->final_price/$package->max_installments, 2, ',', '.') }}</h1></div>
                                <br><br><br>
                            </div>
                            <div class="row" style="text-align: right;margin-right: 0px;" >
                                Total: R$ {{ number_format($package->final_price, 2, ',', '.') }} <i class="fa fa-credit-card"></i>
                            </div>
                            @else
                            @if($package->price != $package->final_price)
                            De: <strike>R$ {{ number_format($package->price, 2, ',', '.') }}</strike>
                        <br/>
                        Por:
                        <br/>
                        @endif
                        <h1>R$ {{ number_format($package->final_price, 2, ',', '.') }}</h1>
                        @if($package->id == 47)
                        10x sem juros
                        @else
                        À Vista
                        @endif
                        @endif

                        </li>
                        <li class="list-group-item" style="margin-bottom: 10px;">
                            8% de desconto no pagamento À  vista (no boleto a partir de R$ 120,00).
                        </li>

                        @endif



                        <li class="list-group-item" style="padding:0" teste="{{$_SERVER["REQUEST_URI"]}}">
                            <a href="{{ route('cart.add', [$package->id, 'package']) }}" class="btn btn-success course-button" style="width:100%; padding: 20px; font-size: 18px; font-color: white;">
                                @if ($package->final_price == 0.00)
                                ACESSE AGORA
                                @else
                                COMPRAR
                                @endif
                            </a>
                        </li>

                        @if($package->id == 45 )
                        <li class="list-group-item" style="padding: 0; margin-top: 10px;">
                            <a data-toggle="modal" data-target="#addUser" href="#" class="btn btn-success course-button" style="background: #ff8415; width:100%;padding: 20px; font-size: 18px; font-color: white;  border:0;">
                                <strong>TESTE GRATUITAMENTE</strong>
                            </a>
                        </li>

                        @endif
                    </ul>

                    <div class="list-group">
                        <button type="button" class="list-group-item" data-toggle="modal" data-target="#termsUses"><i class="fa fa-exclamation-circle"></i> Termos de Uso</button>
                        <button type="button" class="list-group-item" data-toggle="modal" data-target="#requisites"><i class="fa fa-exclamation-circle"></i> Requisitos Minímos</button>
                    </div>

                    @if (count($related) > 0)
                    @foreach($related as $package_related)
                    <div class="post feature-post">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <a href="{{ route('packages.show', [$package_related->slug]) }}"><img class="img-responsive" src="{{ imageurl("packages/", $package_related->id , $package_related->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                            </div>
                        </div>
                        <div class="post-content2">
                            <h2 class="entry-title">
                                <a href="{{ route('packages.show', [$package_related->slug]) }}">R$ {{ number_format($package_related->final_price, 2, ',', '.') }} </a>
                            </h2>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
</section>

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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Requisitos Mínimos</h4>
            </div>
            <div class="modal-body">
                <strong>Desktops e notebooks</strong><br/>
                Largura de banda mínima de 2Mbps<br/>
                Resolução mínima de 1024 x 768 pixels<br/>
                Versão mais atual do do Flash Player<br/>
                Ãšltima versão dos principais Navegadores: Internet Explorer, Mozilla Firefox, Google Chrome e Safari<br/>
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

<br><br>
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

<!-- Modal for course id 550-->
@if($package->id == 45)




<!-- Modal Reta Final-->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div id="tabs-content" class="tab-content">
                <section id="content-export" class="panel">
                    <div class="panel-body row" style='height: 100%;'>
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
                                            Ja sou Cadastrado
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
@endif
