@extends('frontend.layouts.master')

@section('title')
    FAQ | {{app_name()}}
@endsection

@section('content')

    <section id="main-content">
                <div class="container">
                    <h1 class="section-title">FAQ</h1>
                    <p class="meaning-text">Perguntas e respostas mais frequentes</p>
                    <div class="section">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="space"></div>
                                <ul class="post-list">
                                    @foreach($faqcategories as $faqcategory)
                                    <li>
                                        <div class="post small-post active">
                                            <div class="post-content ">
                                                <h2 class="entry-title">
                                                    <a href="#" class="faqmenu faqmenu-{{ $faqcategory->id }}" onclick="javascript: $('.faqmenu').css('color', 'black'); $('.faqmenu-{{ $faqcategory->id }}').css('color', '#2A6395'); $('.faqit').css('display', 'none'); $('.faqit-{{ $faqcategory->id }}').css('display', 'block');  return false;">{{ $faqcategory->description }}</a>
                                                </h2>
                                                <div class="space small"></div>
                                            </div>
                                        </div><!--/post-->
                                    </li>
                                    @endforeach
                                </ul>
                            </div><!--/col-->



                            <div class="col-md-8">

                                @foreach($faqcategories as $faqcategory)
                                    @foreach($faqcategory->faqs as $faq)
                                                    <div class="post faqit faqit-{{ $faqcategory->id }}">
                                                        <div class="post-content">
                                                            <div class="space"></div>
                                                            <h2 class="entry-title">
                                                                {{ $faq->question }}
                                                            </h2>
                                                            <div class="entry-content">
                                                                {!! $faq->answer !!}
                                                            </div>
                                                        </div><!--/post-content-->
                                                    </div><!--/post-->
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </section>

@endsection