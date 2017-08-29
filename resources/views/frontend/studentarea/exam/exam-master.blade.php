@extends('frontend.layouts.master-classroom')

@section('content')

    <section role="main" class="content-body">
        <header class="page-header">
                <h2>SAAP - Sistema de Aprendizagem de Alta Performance</h2>
        </header>


        <!-- start: page -->



            <section class="panel">
                <div class="row">
                    <div class="col-md-6">
                        <section class="panel panel-warning no-border-radius panel-exam">
                            <header class="panel-heading no-border-radius" style="background: #d8f0da;border-left:8px solid #4fba72; border-right:8px solid #4fba72;border-bottom:0;">
                                <h2 class="panel-title" style="color:#4fba72;"><strong>{!!  $exam->title !!}</strong></h2>
                            </header>
                            <div class="panel-body" style="padding:0; padding-bottom: 10px;">
                                <div class="exam-explanation">
                                  @yield('exam-main-panel')
                                </div>
                                @yield('exam-main-extra')
                            </div>
                        </section>
                    </div>

                    <div class="col-md-6">
                        <section class="panel no-border-radius panel-exam" id="explanation" style="padding-top:1px;">
                                    @yield('exam-side-panel')
                        </section>
                    </div>
                </div>



            </section>



@endsection