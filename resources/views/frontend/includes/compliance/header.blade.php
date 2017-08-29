<header id="navigation">
            <div class="navbar" role="banner">
                <div class="topbar">
                    <div class="container" style="height: 100px;">
                        <div id="topbar" class="navbar-header" >
                            <a class="navbar-brand" href="#" >
                                <img class="main-logo img-responsive" style="height: 80px;" id="logonavbar" src="/img/frontend/logo_compliancenet.png" alt="Brasil Jurídico">
                            </a>
                            <div class="hidden-xs hidden-sm">
                                <div id="topbar-right">

                                    <div id="cart" style="border-left: 0px;"><a href="{{ route("cart.items") }}"><i class="fa fa-shopping-cart "></i> </a><span class="badge">{{ Cart::count() }}</span></div>
                                    <div class="searchNlogin">
                                        <ul>
                                            @if(!Auth::guest() && Auth::user()->is("Aluno"))
                                                <li class="dropdown user-panel" style="background-color: #1E376D">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-user" style="color: white"></i>&nbsp;ÁREA DO ALUNO</a>
                                                    <div class="dropdown-menu top-user-section">
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
                                                <li class="dropdown user-panel"  style="background-color: #1E376D" >
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"  role="button"><i class="fa fa-user" style="color:white"></i>&nbsp;ÁREA DO ALUNO </a>
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
                                        {{--<div class="search">--}}
                                            {{--<form action="{{ route('search') }}" method="get">--}}
                                                {{--<input type="text" id="search-form" class="search-form typeahead" autocomplete="off" id="s" name="s" placeholder="Pesquise sobre o seu ramo na área juíridica">--}}
                                            {{--</form>--}}
                                        {{--</div>                                        </ul>--}}
                                    </div><!-- searchNlogin -->

                                    {{--<div class="searchNlogin2">--}}
                                        {{--<ul>--}}
                                            {{--<li class="search-icon"><i class="fa fa-search"></i></li>--}}
                                        {{--</ul>--}}
                                    {{--</div><!-- searchNlogin -->--}}

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
                {{--<div id="menubar" class="container">
                    <nav id="mainmenu" class="navbar-left collapse navbar-collapse"> 
                        <ul class="nav navbar-nav">
                            <li class="menu-item"><a href="{{ route('compliance.institutional.index') }}">BRJ GESTÃO PÚBLICA</a></li>
                            <li class="menu-item"><a href="{{ route('compliance.courses') }}">CURSOS</a></li>
                            <li class="menu-item"><a href="{{ route('compliance.institutional.contract') }}">CONTRATAÇÃO</a></li>
                            <li class="menu-item"><a href="{{ route('compliance.institutional.advantages') }}">DIFERENCIAIS</a></li>
                            <li class="menu-item"><a href="{{ route('compliance.teachers') }}">PROFESSORES ASSOCIADOS</a></li>

                            <li class="menu-item"><a href="{{ route('compliance.news') }}">NOTÍCIAS</a></li>
                            <li class="menu-item"><a href="{{ route('compliance.institutional.termos-de-uso') }}">TERMOS DE USO</a></li>
                            <li class="menu-item"><a href="{{ route('compliance.contactus') }}">FALE CONOSCO</a></li>

                            <a href="{{ route("compliance.cart") }}" class="btn btn-default btn-inverse btn-block btn-lg3 hidden-lg hidden-md"><i class="fa fa-shopping-cart"></i> CARRINHO</a>
                            <a href="/auth/login/" class="btn btn-default btn-inverse btn-block btn-lg3 hidden-lg hidden-md"><i class="fa fa-user"></i> ÁREA DO ALUNO</a>
                        </ul>

                    </nav>
                </div>--}}
                -
            </div>
        </header>