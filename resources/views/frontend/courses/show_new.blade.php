@extends('frontend.layouts.master')

@section('meta-description', $course->title)

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
            <div class="esconde-Botoes" style="padding: 10px;">
                <ul class="list-group">
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


                                Á Vista

                            @endif

                        </li>

                        <img class="img-responsive" src="/img/frontend/meios-pag.png" alt="" style="margin-bottom: 10px;"/>

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

            <div class="col-sm-9 p-bj" style="padding-left: 30px;">
                <div class="row">
                <div id="course-info">
                    <div id="course-body">

                        <ul class="list-group">
                            <li class="list-group-item col-sm-4" >
                                <i class="glyphicon glyphicon-road"></i>&nbsp;&nbsp;
                                Início do Curso<BR> <b>{{ $course->beginOfCourse == null ? "Imediato" : $course->beginOfCourse }}</b>
                            </li>
                            <li class="list-group-item col-sm-4">
                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;
                                Tempo de acesso<BR>  <b>{{ $course->access_time }} dias</b>
                            </li>
                            <li class="list-group-item col-sm-4">
                                <i class="fa fa-eye"></i>&nbsp;&nbsp;
                                Visualizações {{ (($course->workload_presential != null) && ($course->workload_presential != 0)) ? " online" : "" }}<BR>  <b>{{ $course->max_view }} por bloco</b>
                            </li>
                            <li class="list-group-item col-sm-4">
                                <i class="fa fa-clock-o"></i>&nbsp;&nbsp;
                                Carga H. Online<BR>  <b>{{ $course->workload == 0 ? 'A definir' : format_display_time($course->workload * 3600, true) }}</b>
                            </li>
                            <li class="list-group-item col-sm-4">
                                <i class="fa fa-clock-o"></i>&nbsp;&nbsp;
                                Tempo por bloco{{ (($course->workload_presential != null) && ($course->workload_presential != 0)) ? " online" : "" }}<BR>
                                <b>
                                    @if (($course->time_per_content != null) && ($course->time_per_content != ''))
                                    {!! $course->time_per_content !!}
                                    @else
                                    aprox. 30 min.
                                    @endif
                                </b>
                            </li>
                            <li class="list-group-item col-sm-4">
                                <i class="fa fa-clock-o"></i>&nbsp;&nbsp;
                                Carga H. Presencial<BR>  <b>{{ $course->workload_presential == 0 ? "Inexistente" : format_display_time($course->workload_presential * 3600, true) }}</b>
                            </li>
                        </ul>

                    </div>
                </div>
                </div>
                <br>
                <div class="row">
                <div class="col-sm-12">

                    <div data-example-id="togglable-tabs">

                                    {{--<script src="/js/selo.js"></script>--}}
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

                                @if (($course->course_content != null) && ($course->course_content != ''))
                                        <button type="button" class="btn btn-success course-button" data-toggle="modal" data-target="#courseContent"><i class="fa fa-files-o"></i> Conteúdo programático</button>
                                    <BR>
                                @endif
                                @if (($course->methodology != null) && ($course->methodology != ''))
                                    <h2>Metodologia</h2>
                                        <p>{!! $course->methodology !!}</p>
                                @endif
                                @if (($course->testimonials != null) && ($course->testimonials != ''))
                                    <h2>Depoimentos</h2>
                                        <p>{!! $course->testimonials !!}</p>
                                @endif
                                @if (($course->workload_presential == null) || ($course->workload_presential == 0))
                                        <h2>Disciplinas</h2>
                                        @foreach($course->modules as $module)
                                            @if (count($module->teachers) != 0)
                                            <div>
                                                <div  role="tab" id="headingOne">
                                                    <h3>{{$module->name}}</h3>
                                                    <div class="row">
                                                        @foreach($module->teachers as $teacherObj)
                                                            <div class="col-md-12">
                                                                <div class="card">
                                                                    <div class="entry-header col-md-3" style="padding-left: 0px;">
                                                                        <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location ='{{ route("teachers.show", [$teacherObj->slug]) }}'">
                                                                            <a href="{{ route("teachers.show", [$teacherObj->slug]) }}"><img class="img-responsive" src="{{ imageurl('users/', $teacherObj->id, $teacherObj->photo, 200, 'generic.png',true) }}" alt="" /></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="post-content">
                                                                        <h2>
                                                                            <a href="{{ route("teachers.show", [$teacherObj->slug]) }}" >{{ $teacherObj->name }}</a>
                                                                        </h2>
                                                                        <div class="entry-content">
                                                                            <p>{{ str_limit($teacherObj->resume, 300) }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div><!--/.card-->
                                                            </div><!--/.col-->
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                {{--<h2>Docentes</h2>--}}
                                {{--<br>--}}
                                {{--<section class="section professor">--}}
                                    {{--<div class="row">--}}
                                        {{--@foreach($course->teachers as $index => $teacher)--}}

                                            {{--<div class="col-md-12">--}}
                                                {{--<div class="card">--}}
                                                    {{--<div class="entry-header">--}}
                                                        {{--<div class="entry-thumbnail" style="cursor: pointer" onclick="window.location ='{{ route("teachers.show", [$teacher->idOrSlug()]) }}'">--}}
                                                            {{--<a href="{{ route("teachers.show", [$teacher->teacher->idOrSlug()]) }}"><img class="img-responsive" src="{{ imageurl('users/', $teacher->teacher->id, $teacher->teacher->photo, 200, 'generic.png',true) }}" alt="" /></a>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="post-content">--}}
                                                        {{--<h2>--}}
                                                            {{--<a href="{{ route("teachers.show", [$teacher->teacher->idOrSlug()]) }}" >{{ $teacher->teacher->name }}</a>--}}
                                                        {{--</h2>--}}
                                                        {{--<div class="entry-content">--}}
                                                            {{--<p>{{ str_limit($teacher->teacher->resume, 300) }}</p>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div><!--/.card-->--}}
                                            {{--</div><!--/.col-->--}}

                                        {{--@endforeach--}}
                                    {{--</div>--}}
                                {{--</section>--}}
                            <br/>
                        </div>
                    </div>
                </div>
            </div>

            <div style="position:relative;">

                <hr class="visible-xs visible-sm">


            </div>
            <div class="col-sm-3 " style="margin-top: 30px">
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


                            Á Vista

                            @endif

                        </li>

                        <img class="img-responsive" src="/img/frontend/meios-pag.png" alt="" style="margin-bottom: 10px;"/>

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
                    <div class="list-group">
                        <button type="button" class="list-group-item" data-toggle="modal" data-target="#courseContent"><i class="fa fa-files-o"></i> Conteúdo programático</button>
                        <button type="button" class="list-group-item" data-toggle="modal" data-target="#termsUses"><i class="fa fa-exclamation-circle"></i> Termos de Uso</button>
                        <button type="button" class="list-group-item" data-toggle="modal" data-target="#requisites"><i class="fa fa-exclamation-circle"></i> Requisitos Minímos</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal for course id 550-->
@if($course->id == 550)
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
<div class="modal fade" id="courseContent" tabindex="-1" role="dialog" aria-labelledby="courseContentLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Conteúdo Programático</h4>
            </div>
            <div class="modal-body">
                {!! $course->course_content !!}
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
