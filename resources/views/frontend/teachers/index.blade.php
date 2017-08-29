@extends('frontend.layouts.master')

@section('title')
    Professores Associados - Página {{ $teachers->currentPage() }} | {{app_name()}}
@endsection

@section('content')

 <section id="main-content">
    <div class="container">
        <section id="search-meaning">

            <h1 class="section-title">Professores Associados</h1>
        </section>
    </div>
    
    <div class="grey padding-grey">
        <div class="container">
                <div class="row">
                        <form action="/professores" method="get">
                        <div class="form-group">
                            <label class="col-md-4">Busque por professor ou área de atuação</label>
                            <div class="col-md-8 text-left">
                                <input type="hidden" id="f_submit" name="f_submit" value="1">
                                <input type="busca" class="form-control" id="f_search" name="f_search" value="{{ $search }}" placeholder="Digite a área de atuação ou pelo nome do professor">
                            </div>
                        </div>
                        </form>
                </div>
            <br><br><br>
            <ul class="nav" role="tablist" id="nav-secondary-home" style="margin-left: -15px; margin-right: -15px; margin-top:-50px;">
            <li class="col-md-6 col-xs-6 no-padding">
                <a href="/professores?f_submit=1" style="background-color: #cdccf2;" >Listar todos por ordem alfabética</a>
            </li>
            <li class="col-md-6 col-xs-6 no-padding">  
              <a href="#promocoes" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"  style="background-color: #cdccf2; aria-expanded="false">Filtrar por rede social <span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-teachers">
                  <li><a href="/professores?f_submit=1&f_social=facebook">Facebook</a></li>
                  <li><a href="/professores?f_submit=1&f_social=instagram">Instagram</a></li>
                    <li><a href="/professores?f_submit=1&f_social=youtube">Youtube</a></li>
                    <li><a href="/professores?f_submit=1&f_social=linkedin">Linkedin</a></li>
                    <li><a href="/professores?f_submit=1&f_social=jusbrasil">JusBrasil</a></li>
                    <li><a href="/professores?f_submit=1&f_social=twitter">Twitter</a></li>
                    <li><a href="/professores?f_submit=1&f_social=periscope">Periscope</a></li>
                </ul>
            </li>
          </ul>


            @if($teachers->isEmpty())
                <section id="grid-teachers">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p style="color: lightgrey;font-size:16pt;">Não foi encontrado o professor nessa rede social.</p>
                        </div>
                    </div>

                </section>
                @else
            <section id="grid-teachers"> 
                <div class="row">
                    @foreach($teachers as $teacher)
                    <div class="col-md-2">
                        <div class="post feature-post">
                            <div class="entry-thumbnail">
                         <a href="{{ route('teachers.show', $teacher->idOrSlug()) }}" class="card-teacher-title">
                          <img src="{{ imageurl("users/", $teacher->id, $teacher->photo === null || $teacher->photo === '' ? 'X' : $teacher->photo, 200, 'generic.png', 1) }}" class="img-responsive pull-left">
                         </a>
                                </div>
                            <div class="post-content2">
                                <h2 class="entry-title">
                                    <a href="{{ route('teachers.show', $teacher->idOrSlug()) }}" class="card-teacher-title">{{ $teacher->name }}</a>

                                </h2>
                              <!--p>{{ str_limit(strip_tags($teacher->resume), 100) }}</p-->
                              {{--<p>{{ str_replace(';', ', ', $teacher->tags) }}</p>--}}
                              <h4 class="teacher-social-icons">
                                  @if (($teacher->youtube != null) && ($teacher->youtube != ''))
                                      <a href="http://{{ $teacher->youtube }}" target="_blank" ><i class="fa fa-youtube-play" ></i></a> &nbsp;&nbsp;
                                  @endif
                                  @if (($teacher->facebook != null) && ($teacher->facebook != ''))
                                      <a href="http://{{ $teacher->facebook }}" target="_blank"  ><i class="fa fa-facebook-square" ></i></a> &nbsp;&nbsp;
                                  @endif
                                  @if (($teacher->instagram != null) && ($teacher->instagram != ''))
                                      <a href="http://{{ $teacher->instagram }}" target="_blank" ><i class="fa fa-instagram" ></i></a> &nbsp;&nbsp;
                                  @endif
                                      <!--
                                  @if (($teacher->twitter != null) && ($teacher->twitter != ''))
                                      <a href="http://{{ $teacher->twitter }}" target="_blank" ><i class="fa fa-twitter" ></i></a> &nbsp;&nbsp;
                                  @endif
                                  @if (($teacher->linkedin != null) && ($teacher->linkedin != ''))
                                      <a href="http://{{ $teacher->linkedin }}" target="_blank" ><i class="fa fa-linkedin" ></i></a> &nbsp;&nbsp;
                                  @endif
                                  @if (($teacher->jusbrasil != null) && ($teacher->jusbrasil != ''))
                                      <a href="http://{{ $teacher->jusbrasil }}" target="_blank" ><b>JB</b></a> &nbsp;&nbsp;
                                  @endif
                                  @if (($teacher->periscope != null) && ($teacher->periscope != ''))
                                      <a href="http://{{ $teacher->periscope }}" target="_blank" ><b>PC</b></a> &nbsp;&nbsp;
                                  @endif
                                          -->

                              </h4>
                                <div class="clearfix"></div>
                            </div>
                      </div>
                    </div>
                    @endforeach              
                    <div class="clearfix"></div>
                        <div class="text-center">
                            {!! with(new \App\Services\Pagination($teachers))->render() !!}
                        </div>
                </div>

            </section>
                @endif
        </div>
    </div>
</section> 
@endsection
