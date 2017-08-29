<div id="white-bg">
    <div class="container">
        <div class="page-breadcrumbs" style="margin-top:20px; margin-bottom: 10px">
            <h1 class="section-title">Cursos em Destaque</h1>
        </div>

        <div class="section">
            <div class="row">


                @foreach(get_ads() as $course)

                <div class="col-sm-3">
                    <div class="post feature-post">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <a href="{{ route('course-section-ga', ['destaque',$course->slug]) }}"><img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                            </div>
                        </div>
                        <div class="post-content2">
                            <h2 class="entry-title">
                                <a href="{{ route('course-section-ga', ['destaque',$course->slug]) }}">R$ {{ number_format($course->final_price, 2, ',', '.') }} </a>
                            </h2>
                        </div>
                    </div><!--/post-->
                </div><!--/.col-->
                @endforeach

            </div><!--/.row-->
        </div><!--/.section-->
    </div><!--/.container-->
</div><!--/.white-bg-->