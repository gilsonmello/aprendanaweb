
<div class="container">
    <div class="row">
        <div class="section curso-small">
            @foreach($packages as $index => $package)


                @if($index == 0 || $index == ceil($packages->count() / 2.0))
                    <div class="col-md-6 col-sm-12">
                        <div class="space"></div>
                        @endif


                        <div class="post small-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <a href="{{ route('packages.show',[$package->slug]) }}"><img class="img-responsive" src="{{ imageurl("packages/", $package->id , $package->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                </div>
                            </div>
                            <div class="post-content">
                                <span class="label-small label-success">SAAP</span>
                                <h2>
                                    <a href="{{ route('packages.show',[$package->slug]) }}">{{ $package->title }}</a>
                                </h2>
                                <div class="entry-content">
                                    <p>{{ $package->short_description }}</p>
                                </div>
                                <div class="entry-meta">
                                    <p>
                                    @if ($package->final_price == 0.00)
                                        <strong  class="label label-success">GRATUITO</strong>
                                    @else
                                        R$ {{number_format($package->final_price, 2, ',', '.')}}
                                    @endif
                                    </p>
                                </div>
                            </div>
                        </div><!--/card-->

                        @if($index == (ceil($packages->count() / 2.0) - 1) || $index == $packages->count() - 1  )
                    </div>
                @endif
            @endforeach
        </div><!--/.section-->
    </div><!--/.row -->
</div><!--/.container-->
