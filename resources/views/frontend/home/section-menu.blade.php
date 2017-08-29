<div id="white-feed">
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="site-content col-md-12">
                    <div class="row">
                        @foreach($sections as $index=>$section)
                            @if($section->addimg != null)
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="post feature-post" style="cursor: pointer" onclick="window.location='/{{$section->slug}}'">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img class="img-responsive" src="{{ imageurl("sections/", $section->id, $section->addimg, 0, 'saap_home.png') }}" alt="" />
                                            </div>
                                        </div>
                                        <div class="post-content">
                                            <h2 class="entry-title">
                                                <a href="/{{ $section->slug }}">{{ $section->name }}</a>
                                            </h2>
                                        </div>
                                    </div><!--/post-->
                                </div>
                            @endif
                        @endforeach
                    </div><!--/.site content-->
                </div><!--/.row-->
            </div><!--/.section-->
        </div><!--/.container-->
    </div>
</div>
