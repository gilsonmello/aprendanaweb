<header id="navigation">
            <div class="navbar" role="banner">
                <div class="container">
                    <a class="secondary-logo" href="/">
                        <img class="img-responsive" src="/img/frontend/Logo_Brasil_Juridico_Cursos_Online.png" alt="Brasil Jurídico">
                    </a>
                </div>
                <div class="topbar">
                    <div class="container">
                        <div id="topbar" class="navbar-header">                         
                            <a class="navbar-brand" href="/">
                                <img class="main-logo img-responsive" id="logonavbar" src="/img/frontend/Logo_Brasil_Juridico_Cursos_Online.png" alt="Brasil Jurídico">
                            </a>
                            <div class="hidden-xs hidden-sm">
                                <div id="topbar-right">

                                </div>
                            </div>
                        </div>
                    </div> 
                </div> 
                {{--<div id="menubar" class="container">    --}}
                    {{--<nav id="mainmenu" class="navbar-left collapse navbar-collapse"> --}}
                        {{--<ul class="nav navbar-nav">--}}
                            {{--<li class="politics dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">SOBRE O BrJ</a>--}}
                                {{--<ul class="dropdown-menu">--}}
                                    {{--<li><a href="{{ route('bj') }}">INSTITUCIONAL</a></li>--}}
                                    {{--<li><a href="{{ route('teachers') }}">PROFESSORES ASSOCIADOS</a></li>--}}
                                    {{--<li><a href="{{ route('termos-de-uso') }}">TERMOS DE USO</a></li>--}}
                                    {{--<li><a href="{{ route('contactus.index') }}">FALE CONOSCO</a></li>--}}
                                    {{--<li><a href="{{ route('faqs') }}">FAQ</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<li class="menu-item"><a href="{{ route('analysis.about') }}">ANÁLISE 360°</a></li>--}}
                            {{--<li class="menu-item"><a href="{{ route('packages.about') }}">CONHEÇA O SAAP</a></li>--}}

                            {{--@foreach(App\Section::all()->reject(function($item){ return $item->addimg == null || $item->active == 0; })->sortBy('sequence')->take(4) as $section)--}}
                                {{--<li class="menu-item" style="text-transform: uppercase;"><a href="/{{ $section->slug }}">{!! strtoupper($section->name) !!}</a></li>--}}

                            {{--@endforeach--}}

                            {{--<li class="menu-item dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">+ INFORMAÇÃO</a>--}}
                                {{--<ul class="dropdown-menu">--}}
                                    {{--<li><a href="{{ route('tv-videos') }}">TEMAS EM DESTAQUE</a></li>--}}
                                    {{--<li><a href="{{ route('news') }}">NOTÍCIAS</a></li>--}}
                                    {{--<li><a href="{{ route('articles') }}">ARTIGOS</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<a href="/auth/login/" class="btn btn-default btn-inverse btn-block btn-lg3 hidden-lg hidden-md"><i class="fa fa-user"></i> ÁREA DO ALUNO</a>--}}
                        {{--</ul>--}}

                    {{--</nav>--}}
                {{--</div>--}}
            </div>
        </header>