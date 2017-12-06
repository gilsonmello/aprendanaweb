<header class="header" id="header-site">

    <div class="logo-container">
        <a href="/dashboard" class="logo" >
            <img src="/img/frontend/aprendanaweb.jpg" alt="Brasil Jurídico" width="70" height="70" />
        </a>
        <!--div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div-->
    </div>

    <div class="toggle-sidebar-left" id="show-menu-header" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
    </div>
    <div class="header-right" id="user-student-logged" style="margin-top: 10px;">

     @if(Auth::user()->is("Aluno"))

     <!-- start: search & user box -->
     <div class="header-right" style="position: absolute; z-index: 99; top: -2px; right: 50px;">

        <div class="pull-left" id="menu-dashboard" style="f">

            {{--
            @if(!Auth::user()->enrollments->whereLoose('partner_id',1)->isEmpty())
            <a href="{{ Route('frontend.knowledge') }}"  class="header-menu">
                <i class="fa fa-book" aria-hidden="true"></i>&nbsp;
                <span>BASE DE CONHECIMENTO</span>
            </a>
            @endif
            --}}
            <a href="{{ Route('frontend.courses') }}"  class="header-menu">
                <i class="fa fa-tv" aria-hidden="true"></i>&nbsp;
                <span>MEUS CURSOS</span>
            </a>
            <a href="{{ Route('frontend.exams') }}"  class="header-menu">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;
                <span>MEUS SAAP's</span>
            </a>
            @if(user_has_enrollments_in_course_type('ask_the_teacher', '=', '1') == true || user_has_ask_the_tutor())
                <a href="{{ Route('student.asktheteacher') }}"  class="header-menu">
                    <i class="fa fa-comments" aria-hidden="true"></i>&nbsp;
                    <span>MINHAS DÚVIDAS</span>
                </a>
            @endif
            <a href="{{ Route('student.ticketstudents.index') }}"  class="header-menu">
                <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
                <span>FALE CONOSCO</span>
            </a>
            {{--<a href="{{ Route('student.orders') }}"  class="header-menu">--}}
                {{--<i class="fa fa-shopping-bag" aria-hidden="true"></i>&nbsp;--}}
                {{--<span>PEDIDOS</span>--}}
            {{--</a>--}}
            <a href="{!! Route('profile.edit', Auth::user()->id) !!}"  class="header-menu">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                <span>PERFIL</span>
            </a>
            <a href="/"  class="header-menu">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;
                <span>LOJA</span>
            </a>
        </div>
        <span class="separator" style="background:none;"></span>

        <ul class="notifications">
            <li>
                <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="badge">{{ Auth::user()->notifications->whereLoose('is_read',0)->count() }}</span>
                </a>

                <div class="dropdown-menu notification-menu">
                    <div class="notification-title" style="background:#c52f33;">
                        <span class="pull-right label label-danger">{{ Auth::user()->notifications->count() }}</span>
                        Notificações 
                    </div>

                    <div class="content">
                        <ul>

                            @foreach(Auth::user()->notifications->sortByDesc('created_at') as $notification)
                            <div class="notification-item" data-notification-id="{{ $notification->id }}">
                                @if($notification->is_read == 1)
                                <li>
                                    @else
                                    <li style="font-weight: bold; margin-bottom: 10px;">
                                        @endif
                                        <a href="{{ $notification->notificationMessage->route }}" class="clearfix">
                                            <div class="image">
                                                <i class="fa {{ $notification->notificationMessage->icon }}"></i>
                                            </div> 
                                            <!-- <span class="title">Atenção</span> -->
                                            <span class="message">{{ $notification->notificationMessage->message }}</span>
                                        </a>
                                    </li>
                                </div>
                                @endforeach
                            </ul>

                            <hr />

                            <!--
                            <div class="text-right">
                                <a href="#" class="view-more">View All</a>
                            </div> -->
                        </div>
                    </div>
                </li>
            </ul>
            &nbsp;&nbsp;&nbsp;&nbsp;

            
            <div id="userbox" class="userbox">
                <a href="{!! Route('profile.edit', Auth::user()->id) !!}">
                    <figure class="profile-picture">
                        <img width="35" src="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100, 'generic.png', true) }}" class="img-circle" data-lock-picture="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100) }}">
                    </figure>
                </a>
            </div>

            <div id="" class="userbox" style="margin-top: -17px;">&nbsp;&nbsp;&nbsp;
                <div id="menu-dashboard" class="pull-right"> 
                    <a href="/auth/logout" class="header-menu">
                        <i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;
                        <span>SAIR</span>
                    </a>
                </div>
            </div>
        </div>
        @endif


    </div>

</header>