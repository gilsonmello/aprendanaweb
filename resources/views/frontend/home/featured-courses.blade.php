
<div class="container">
    <div class="section">
        <div class="row">
            <div class="site-content col-md-12">
<div class="row">
    @foreach($coursesFeatured->take(4) as $course)

        <div class="col-sm-3">
            <div class="post feature-post" style="cursor: pointer" onclick="window.location='{{ route('course-section', [$course->slug]) }}'" >

                <div class="entry-header">
                    <div class="entry-thumbnail">
                        <img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                    </div>
                </div>
                <div class="post-content2">
                    <h2 class="entry-title">
                        <a>R$ {{ number_format($course->final_price, 2, ',', '.') }}</a>
                    </h2>
                </div>

            </div><!--/post-->
        </div><!--/.col-->
    @endforeach
</div>
            </div><!--/#content-->
        </div><!--/.row-->
    </div><!--/.section-->
</div><!--/.container-->
