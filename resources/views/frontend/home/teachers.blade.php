<div id="section"  style="padding-bottom: 20px">
    <div class="container">
        <div class="page-breadcrumbs" style="margin-top:0px; margin-bottom: 0px">
            <a href="{{ route("teachers") }}"><h1 class="section-title">Professores Associados</h1></a>
            <div class="world-nav cat-menu">
                <ul class="list-inline">
                    <li><a href="{{ route("teachers") }}"><strong>Todos os Professores</strong></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            @foreach($teachers as $teacher)
                <div class="col-sm-2 col-xs-6">
                    <a href="{{ route("teachers.show", [$teacher->idOrSlug()]) }}">
                        <div class="post feature-post">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="{{ imageurl('users/', $teacher->id, $teacher->photo, 200, 'generic.png',true) }}" alt="" />
                            </div>
                            <div class="post-content2">
                                <h2 class="entry-title" style="color: white;">
                                    {{ $teacher->name }}
                                </h2>
                            </div>
                        </div><!--/post-->
                    </a>
                </div><!--/.col-->
            @endforeach
        </div><!--/.row -->
    </div><!--/.container -->
</div><!--/.section -->
