@extends('frontend.layouts.master-classroom')

@section('content')

    <section role="main" class="content-body">
        <header class="page-header">
            <h2>{{ $exam->title }}</h2>
        </header>


        <!-- start: page -->



        <section class="panel">
            <div class="row">

                <!--


                </div> -->
                <div class="col-md-6">

                    <section class="panel panel-warning no-border-radius panel-exam">
                        <header class="panel-heading no-border-radius" style="background: #d8f0da;border-left:8px solid #4fba72; border-right:8px solid #4fba72;border-bottom:0;">
                             <h2 class="panel-title" style="color:#4fba72;">{!!  $exam->title !!}</h2>
                        </header>
                        <div class="panel-body" style="padding:0;">
                            <div id="exam-presentation">
                                @include('frontend.studentarea.exam.results')
                            </div>
                            <br/>
                        </div>
                    </section>

                </div>

                <div class="col-md-6">

                    <section class="panel no-border-radius panel-exam" id="explanation" style="display:none; padding-top:1px;">
                    <header class="panel-heading no-border-radius" style="background: #d8eceb;border-left:8px solid #253885; border-right:8px solid #253885;border-bottom:0;">
                            <h2 class="panel-title" style="color:#253885;"></h2>
                        </header>
                        <div class="panel-body" style="padding:0;">
                            <iframe width="100%" id="explanation-content" height="400" src="#" frameborder="0" allowfullscreen></iframe>
                            <div id="explanation-text"></div>
                        </div>
                </div>

            </div>
        </section>





        </div>



    </section>
    </div>
    </div>

@endsection