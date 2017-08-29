<div class="container" >
    <div class="section">
        <div class="row">
            <div class="site-content col-md-12">
                <div class="row">
                    <div class="col-sm-6" style="width: 100%;">
                        <div class="post feature-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <a href="/simulados/1-simulador-saap-para-o-xxii-exame-de-ordem">
                                        <img class="img-responsive" width="100%" style="cursor: pointer" src="/img/frontend/banner_80_faca_a_prova_antes_da_prova.jpg"> </a>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
                <br> 
                <div class="row">
                    @if (count($firstBanner) != 0)
                    <div class="col-sm-6">
                        <div class="post feature-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <img class="img-responsive" style="cursor: pointer" onclick="window.location ='{{ route('course-section', [$firstBanner->url])}}'" src="{{ imageurl("banners/", $firstBanner->id , $firstBanner->img, 0, 'course_home.jpg') }}" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(count($carousels) != 0)
                    <div class="col-sm-6">
                        <div id="carousel">
                            @foreach($carousels as $carousel) 
                            <div class="post feature-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail">
                                        <img class="img-responsive" style="cursor: pointer" onclick="window.location ='{{ route('course-section', [$carousel->url])}}'" src="{{ imageurl("banners/", $carousel->id , $carousel->img, 0, 'course_home.jpg') }}" alt="" />
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if (count($banners) != 0)
                    @foreach($banners as $banner)
                    @if($banner->order > 1)
                    <div class="col-sm-6">
                        <div class="post feature-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <img class="img-responsive" style="cursor: pointer" onclick="window.location ='{{ route('course-section', [$banner->url])}}'" src="{{ imageurl("banners/", $banner->id , $banner->img, 0, 'course_home.jpg') }}" alt="" />
                                </div>
                            </div>
                            <!-- Solicitação de fontenele para retirar o sombreado dos banners -->
                            {{-- <div class="post-content2">
                                            <h2 class="entry-title">
                                                @if (($banner->course != null) || ($banner->package != null))
                                                <a href="{{ $banner->url }}">R$ {{ number_format(($banner->course != null ? $banner->course->final_price : $banner->package->price),2,',','.') }} </a>
                            @endif
                            </h2>
                        </div> --}}
                    </div><!--/post-->
                </div><!--/.col-->
                @endif
                @endforeach
                @endif
            </div><!--/.row-->
        </div><!--/#content-->
    </div><!--/.row-->
</div><!--/.section-->
</div><!--/.container-->

