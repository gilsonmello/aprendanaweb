<div id="white-bg">
    <div class="section" style="margin-bottom: 0px !important;">
        <div class="container">
            <div class="page-breadcrumbs" style="margin-top:10px; margin-bottom: 0px">
                <a href="{{ route("articles") }}"><h1 class="section-title">Artigos</h1></a>
                <div class="world-nav cat-menu">
                    <ul class="list-inline">
                        <li><a href="{{ route("articles") }}"><strong>Mais Artigos</strong></a></li>
                    </ul>
                </div>
            </div>
            <div class="space small"></div>
            @if($count_articles = $articles->take(4)->count()) @endif
            @foreach($articles->take(4) as $index => $article)
                @if($index == 0 || $index == ceil($count_articles / 2.0))
                    <div class="row">
                        @endif
                        <div class="col-md-6">
                            <div class="media">
                                <div class="pull-left">
                                <span class="fa fa-stack fa-3x">
                                      @if (($article->users != null) && ($article->users->first() != null))
                                        <img class="img-responsive img-circle" src="{{ imageurl('users/', $article->users->first()->id, $article->users->first()->photo, 200, 'generic.png',true) }}" alt="">
                                    @else
                                        <img class="img-responsive img-circle" src="{{ imageurl('users/', '', '', 200, 'generic.png',true) }}" alt="">
                                    @endif
                                </span>
                                </div>
                                <div class="media-body">
                                    <div class="heading-line color-secondary small left"></div>
                                    @if (($article->users != null) && ($article->users->first() != null))
                                        <h6>{{ $article->users->first()->name}}</h6>
                                    @else
                                        <h6>Autor não informado</h6>
                                    @endif
                                    <h5><a href="{{ route("articles.show", [$article->slug]) }}" title="{{ strlen( $article->title ) > 100 ? $article->title : ""}}">{{ str_limit($article->title,100) }}</a></h5>
                                </div>
                            </div>
                        </div><!-- /.col -->
                        @if($index != 0 && $index %  ceil($count_articles / 2.0) == (ceil($count_articles / 2.0) - 1)    || ($index == $count_articles - 1))
                    </div>

                @endif
            @endforeach
        </div><!-- /.container-->
    </div>
</div>
