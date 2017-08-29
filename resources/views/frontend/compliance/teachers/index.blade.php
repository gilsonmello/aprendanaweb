@extends('frontend.layouts.masterpublicsector')

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


            @if($teachers->isEmpty())
                <section id="grid-teachers">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p style="color: lightgrey;font-size:16pt;">Não foi encontrado o professor.</p>
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
                         <a href="{{ route('publicsector.teacher', $teacher->idOrSlug()) }}" class="card-teacher-title">
                          <img src="{{ imageurl("users/", $teacher->id, $teacher->photo === null || $teacher->photo === '' ? 'X' : $teacher->photo, 200, 'generic.png', 1) }}" class="img-responsive pull-left">
                         </a>
                                </div>
                            <div class="post-content2">
                                <h2 class="entry-title">
                                    <a href="{{ route('publicsector.teacher', $teacher->idOrSlug()) }}" class="card-teacher-title">{{ $teacher->name }}</a>

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
            <BR>
        </div>
    </div>
</section> 
@endsection
