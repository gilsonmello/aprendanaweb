<header id="navigation">
    <div class="navbar" role="banner">
        <div class="container">
            <a class="secondary-logo" href="{!! route('home') !!}">
                <img class="img-responsive" src="/img/frontend/aprendanaweb.jpg" alt="Brasil Jurídico">
            </a>
        </div>
        <div class="topbar">
            <div class="container">
                <div id="topbar" class="navbar-header">                         
                    <a class="navbar-brand" href="{!! route('home') !!}">
                        <img class="main-logo img-responsive" id="logonavbar" src="/img/frontend/aprendanaweb.jpg" alt="Brasil Jurídico">
                    </a>
                    <div class="hidden-xs hidden-sm">
                        <div id="topbar-right">
                            <ul class="nav navbar-nav">
                                <li><a href="{{ route('contactus.index') }}" style="color: #1E376D;"><i class="fa fa-envelope"></i> Fale Conosco</a></li>
                                <li><a href="#" target="_blank" style="color: #1E376D;"><i class="fa fa-facebook"></i> Facebook</a></li>
                                <li><a href="#" target="_blank" style="color: #1E376D;"><i class="fa fa-instagram"></i> Instagram</a></li>
                                <li><a href="#" target="_blank" style="color: #1E376D;"><i class="fa fa-youtube-play"></i> YouTube</a></li>
                            </ul>

                            <div id="cart"><a href="{{ route("cart.items") }}" style="text-transform: uppercase; color: #1E376D;"><i class="fa fa-shopping-cart "></i> </a><span class="badge">{{ Cart::count() }}</span></div>

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
                                                <a style="padding-left: 0" href="/dashboard" id="btn-register-solid" class="btn mb-md ml-xs mr-xs dark-menu-text">Ir para área do aluno</a>
                                                <a style="padding-right: 0; padding-left: 30%;" href="/auth/logout" id="btn-register-solid" class="btn mb-md ml-xs mr-xs dark-menu-text">Sair </a>
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

                @foreach(App\Section::all()->reject(function($item){
                    return $item->active == 0; })->sortBy('sequence')->take(5) as $section)

                        @if($subsections_filtered = $section->subsections->reject(function($item){ return $item->courses(0)->get()->isEmpty() && $item->packages(0)->get()->isEmpty(); })->sortBy('name'))@endif

                @if(!$subsections_filtered->isEmpty() && $subsections_filtered->count() >= 1)

                <li class="menu-item dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" style="text-transform: uppercase;  color: #1E376D;">{!! strtoupper(($section->menu_name != null && $section->menu_name != "") ? $section->menu_name : $section->name) !!}</a>
                    <ul class="dropdown-menu">
                        @foreach($subsections_filtered as $subsection)
                        <li><a href="/{{ $section->slug }}/{{ $subsection->slug }}" style="text-transform: uppercase; color: #1E376D;" >{{ $subsection->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @else
                <li class="menu-item" style="text-transform: uppercase;">
                    <a href="/{{ $section->slug }}" style="color: #1E376D;">
                        {!! strtoupper(($section->menu_name != null && $section->menu_name != "") ? $section->menu_name : $section->name) !!}
                    </a>
                </li>
                @endif
                @endforeach

                <li class="menu-item dropdown" ><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"  style="color: #1E376D;">+INFORMAÇÃO</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('news') }}"  style="color: #1E376D;">NOTÍCIAS</a></li>
                        <li><a href="{{ route('articles') }}"  style="color: #1E376D;">ARTIGOS</a></li>
                    </ul>
                </li>

                <a href="{{ route("cart.items") }}" class="btn btn-default btn-inverse btn-block btn-lg3 hidden-lg hidden-md"><i class="fa fa-shopping-cart"></i> CARRINHO</a>
                <a href="/dashboard/" class="btn btn-default btn-inverse btn-block btn-lg3 hidden-lg hidden-md"><i class="fa fa-user"></i> ÁREA DO ALUNO</a>
                @if(!Auth::guest() && Auth::user()->is("Aluno"))
                <a href="/auth/logout" class="btn btn-default btn-inverse btn-block btn-lg3 hidden-lg hidden-md"><i class="fa fa-power-off"></i> Sair</a>
                @endif
                </ul>

            </nav>
        </div>
    </div>
</header>