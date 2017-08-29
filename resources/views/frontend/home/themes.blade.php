<div class="container" style="padding-bottom: 20px">
    <div class="page-breadcrumbs" style="margin-top:10px; margin-bottom: 0px">
        <a href="{{ route("videos") }}"><h1 class="section-title">Temas em Destaque</h1></a>
        <div class="world-nav cat-menu">
            <ul class="list-inline">
                <li><a href="{{ route("videos") }}"><strong>Mais Temas em Destaque</strong></a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        @foreach($videos->take(4) as $video)
            <div class="col-md-3">
                <div class="post medium-post">
                    <div class="entry-header">
                        <div class="entry-thumbnail">
                            <img class="img-responsive" src="{{ imageurl('tv-videos/', $video->id, $video->img, 400, 'generic.png',false) }}" alt="" />
                        </div>
                    </div>
                    <div class="post-content" style="height: 90px; overflow: hidden; text-overflow: ellipsis;">
                        <h2 class="entry-title">
                            <a href="{{ route("videos.show", [$video->slug]) }}">{{ $video->title }}</a>
                        </h2>
                    </div>
                </div><!--/post-->
            </div>
        @endforeach
    </div>
</div><!--/.container -->
