<header id="navigation" class="header-fix blackfiday-bar-top black" >
    <div class="navbar" role="banner" style="margin-bottom: 0px;">
        <div class="container">

            <a class="secondary-logo" href="{!! route('home') !!}">
                <img class="img-responsive" src="/img/frontend/logo-blackfriday.png" alt="Brasil Jurídico">
            </a>
 
        </div>
        <div class="topbar">
            <div class="container">
                <div id="topbar" class="navbar-header">                         
                    <a class="navbar-brand" href="{!! route('home') !!}">
                      
                        <img class="main-logo img-responsive"  id="logonavbar" src="/img/frontend/logo-blackfriday.png" alt="Brasil Jurídico">
                        
                    </a>
                    <div class="hidden-xs hidden-sm">
                        <div id="topbar-right">
                            <ul class="nav navbar-nav">
                                <li><a class="blackfiday-font" href="{{ route('contactus.index') }}"><i class="fa fa-envelope "></i> Fale Conosco</a></li>
                                <li><a href="https://www.facebook.com/BrasilJuridicoCursos" target="_blank"><i class="fa fa-facebook"></i> Facebook</a></li>
                                <li><a href="https://www.instagram.com/brasiljuridico/" target="_blank"><i class="fa fa-instagram"></i> Instagram</a></li>
                                <li><a href="https://www.youtube.com/channel/UC3FD5PHIbVPvVjYDAfpq_Mw" target="_blank"><i class="fa fa-youtube-play"></i> YouTube</a></li>
                            </ul>

                            <div id="cart"><a href="{{ route("cart.items") }}"><i class="fa fa-shopping-cart "></i> </a><span class="badge" style="background-color: #ffff00">{{ Cart::count() }}</span></div>




                            <div class="searchNlogin">
                                <ul>
                                    @if(!Auth::guest() && Auth::user()->is("Aluno"))
                                    <li class="dropdown user-panel" style="background-color: #ffff00">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-user" style="color: white"></i>&nbsp;ÁREA DO ALUNO</a>
                                        <div class="dropdown-menu top-user-section" style="background-color:#000">
                                            <div class="top-user-form">
                                                <div class="input-group dark-menu-text" id="top-notice">
                                                    Você tem {{ Auth::user()->notifications->whereLoose('is_read','0')->count() }} notificações não lidas.
                                                </div>

                                            </div>
                                            <div class="create-account ">
                                                <a href="/dashboard" id="btn-register-solid" class="btn mb-md ml-xs mr-xs dark-menu-text">Ir para área do aluno</a>
                                            </div>
                                        </div>
                                    </li>
                                    @else
                                    <li class="dropdown user-panel"  style="background-color: #ffff00" >
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"  role="button" style="color:#000"><i class="fa fa-user" style="color:#000"></i>&nbsp;ÁREA DO ALUNO </a>
                                        <div id="user-section" class="dropdown-menu top-user-section">
                                            <div class="top-user-form">
                                                {!! Form::open(['url' => 'auth/login', 'id' => 'top-login', 'class' => 'form-horizontal', 'role' => 'form']) !!}

                                                <div class="input-group" id="top-login-username">
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                    {!! Form::input('email', 'email', old('email'), ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'Email']) !!}
                                                </div>
                                                <div class="input-group" id="top-login-password">
                                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                    {!! Form::input('password', 'password', null, ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Senha']) !!}
                                                </div>
                                                <div>
                                                    <p class="reset-user"><a>{!! link_to('password/email', trans('labels.forgot_password'), ['id' => 'btnEsqueci', 'style' => 'margin-top:8px','class' => 'gray-hover']) !!}</a></p>
                                                    {!! Form::submit(trans('labels.login_button'), ['id' => 'btnLogin', 'style' => 'width:40%;', 'class' => 'btn btn-success pull-right']) !!}
                                                </div>

                                                <div>
                                                    <a href="/auth/login/facebook" id="btn-facebook-solid" style="width:100%" class="btn btn-facebook btn-info mb-md ml-xs mr-xs">Conecte com o <i class="fa fa-facebook"></i></a>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                            <div class="create-account">
                                                <a href="/auth/register" id="btn-register-solid" class="btn mb-md ml-xs mr-xs grey-hover dark-menu-text">Cadastre-se</a>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                                <div class="search">
                                    <form action="{{ route('search') }}" method="get">
                                        <input type="text" id="search-form" class="search-form typeahead" autocomplete="off" id="s" name="s" placeholder="Pesquise sobre o seu ramo na área juíridica">
                                    </form>
                                </div>                                        </ul>
                            </div><!-- searchNlogin -->

                            <div class="searchNlogin2">
                                <ul>
                                    <li class="search-icon"><i class="fa fa-search"></i></li>
                                </ul>
                            </div><!-- searchNlogin -->

                        </div>
                    </div>

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> 
            </div> 
        </div> 
        <div id="menubar" class="container">    
            <nav id="mainmenu" class="navbar-left collapse navbar-collapse"> 
                <ul class="nav navbar-nav">
                    <li class="politics dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">SOBRE<br>O BRJ</a>
                        <ul class="dropdown-menu" style="background-color: #000" >
                            <li><a href="{{ route('bj') }}">INSTITUCIONAL</a></li>
                            <li><a href="{{ route('teachers') }}">PROFESSORES ASSOCIADOS</a></li>
                            <li><a href="{{ route('termos-de-uso') }}">TERMOS DE USO</a></li>
                            <li><a href="{{ route('contactus.index') }}">FALE CONOSCO</a></li>
                            {{--<li><a href="{{ route('faqs') }}">FAQ</a></li>--}}
                </ul>
                </li>
                <li class="menu-item"><a href="{{ route('analysis.about') }}">CONHEÇA O<BR>ANÁLISE 360°</a></li>
                <li class="menu-item"><a href="{{ route('packages.about') }}">CONHEÇA<BR> O SAAP</a></li>

                @foreach(App\Section::all()->reject(function($item){ return $item->active == 0; })->sortBy('sequence')->take(5) as $section)
                <li class="menu-item" style="text-transform: uppercase;">
                    <a href="/{{ $section->slug }}">
                        {!! strtoupper(($section->menu_name != null && $section->menu_name != "") ? $section->menu_name : $section->name) !!}
                    </a>
                </li>
                @endforeach

                <li class="menu-item dropdown" >
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" >+INFORMAÇÃO</a>
                    <ul class="dropdown-menu" style="background-color: #000">
                        <li><a href="{{ route('tv-videos') }}">TEMAS EM DESTAQUE</a></li>
                        <li><a href="{{ route('news') }}">NOTÍCIAS</a></li>
                        <li><a href="{{ route('articles') }}">ARTIGOS</a></li>
                    </ul>
                </li>
                <a href="{{ route("cart.items") }}" class="btn btn-default btn-inverse btn-block btn-lg3 hidden-lg hidden-md"><i class="fa fa-shopping-cart"></i> CARRINHO</a>
                <a href="/auth/login/" class="btn btn-default btn-inverse btn-block btn-lg3 hidden-lg hidden-md"><i class="fa fa-user"></i> ÁREA DO ALUNO</a>
                </ul>
            </nav>
        </div>
    </div>
</header>

