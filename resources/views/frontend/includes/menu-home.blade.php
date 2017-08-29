    <div class="navbar yamm hidden-md hidden-xs hidden-sm" style="margin-top: -30px;margin-bottom:0" id="primary-nav-bj">
    <div class="container" style="padding:0px 8px;">
        <div class="navbar-collapse collapse no-padding">

        <ul class="nav">

            @foreach($sections as $section)
            <li class="dropdown yamm-fw" style="width:14.28%; float: left;background: {{ $section->color }};">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle anchor"
                   aria-expanded="true">{{ $section->name }}</a>

                @if(count($section->courses(6)) > 0)
                <ul class="dropdown-menu" style="background: {{ $section->color }}!important">
                    <li class="grid-demo">
                        <ul class="col-md-6">
                            @foreach($section->courses(5) as $course)
                                <li style="width: 50%!important; float: left;">
                                    <div class="btn-group">
                                        <a href="{{ route('course-section', [$course->slug]) }}" class="">
                                            {{ $course->title }}
                                            <i class="icon icon-caret-right"></i>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                            <li style="width: 50%!important; float: left;">
                                <div class="btn-group">
                                    <a href="{{ route('course-section', [$section->slug]) }}" class="">
                                        <b>Todos os cursos</b>
                                        <i class="icon icon-caret-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <div class="col-md-6">
                            <img src="{{ imageurl("sections/", $section->id, $section->addimg, 0, 'genericsolid.jpg', 1) }}" class="img-responsive">
                        </div>
                    </li>
                </ul>
                @endif
            </li>
            @endforeach

            <li class="dropdown yamm-fw navy-bj"  style="width:14.28%; float: left;"><a href="{{ Route("courses")  }}" >Todos os Cursos</a></li>

        </ul>

        </div>
    </div>
</div>