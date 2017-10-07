<!-- Main Header -->
<!-- Google Analytics -->
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
</script>
<!-- End Google Analytics -->

<header class="main-header">

    <!-- Logo -->
    <a href="{!!route('backend.dashboard')!!}" class="logo"><b>{{ app_name() }}</b></a>


    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 50) }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ access()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100) }}" class="img-circle" alt="User Image" />
                            <p>
                                {{ access()->user()->name }}
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!--li class="user-body">
                          <div class="col-xs-4 text-center">
                            <a href="#">Link</a>
                          </div>
                          <div class="col-xs-4 text-center">
                            <a href="#">Link</a>
                          </div>
                          <div class="col-xs-4 text-center">
                            <a href="#">Link</a>
                          </div>
                        </li-->
                        <!-- Menu Footer-->


                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#passwordModal">{{ trans('navs.change_password') }}</a>
                            </div>
                            <div class="pull-right">
                                <a href="{!!url('admin/auth/logout')!!}" class="btn btn-default btn-flat">{{ trans('navs.logout') }}</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>


</header>
