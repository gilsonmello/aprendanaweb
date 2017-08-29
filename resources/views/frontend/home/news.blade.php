<div id="white-bg">
    <div class="container">
        <div class="page-breadcrumbs" style="margin-top:10px; margin-bottom: 0px">
            <a href="{{ route("news") }}"><h1 class="section-title title">Notícias</h1></a>
            <div class="world-nav cat-menu">
                <ul class="list-inline">
                    <li><a href="{{ route("news") }}"><strong>Mais Notícias</strong></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            @foreach($news->take(2) as $new)
                <div class="col-md-4">

                    <div class="noticiacard">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="{{ imageurl('news/', $new->id, $new->img, 400, 'generic.png',false) }}" alt="" />
                            </div>
                        </div>
                        <div class="noticiacard-content">
                            <div class="entry-date">
                                <span class="publish-date"> {{  $new->date }}</span>
                            </div>
                            <h2 class="title">
                                <a href="{{ route("news.show", [$new->slug]) }}">{{ $new->title }}</a>
                            </h2>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-md-4">
                @foreach($news->splice(2)->take(3) as $new)
                    <div class="noticia">
                        <div class="entry-date">
                            <span class="publish-date"> {{  $new->date }}</span>
                        </div>
                        <h4>
                            <a href="{{ route("news.show", [$new->slug]) }}">{{ $new->title }}</a>
                        </h4>
                    </div>

                @endforeach
            </div><!--/.col-->
        </div><!--/.row-->
    </div><!--/.container-->
</div><!--/.white-bg-->
