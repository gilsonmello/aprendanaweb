@extends('frontend.layouts.master-classroom')

@section('content')
    <section role="main" class="content-body">
        <div id="course" class="container">
            <div class="row">
                <div class="col-md-12" >
                    <div id="tabs-content" class="tab-content">
                        <div id="module-tab" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-3" style="float: right !important; ">
                                    <a id="btn-export" type="button" class="mb-xs mt-xs mr-xs btn btn-primary green-jungle" style="width:100%; font-size: 1.7rem;" >
                                        <i class="fa fa-print"></i>&nbsp;&nbsp;Imprimir Anotações
                                    </a>
                                </div >
                            </div>
                            <section id="content-export" class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-8" style="margin-left: 3%;">
                                            <h3>
                                                <strong>
                                                    {{ $enrollment->exam->title }}
                                                </strong>
                                            </h3>
                                        </div>
                                    </div>
                                    <table class="table table-hover mb-none" style="margin-top: 20px; font-size:1.6rem">
                                        <tbody>
                                            @foreach($questions as $question)
                                                @if(!empty($question->note))
                                                    <tr>
                                                        <td align="left" style="border-top: none;" >
                                                            <p style="border-top: none; margin-left: 40px; margin-top: 7px; margin-bottom: 0;">
                                                                <strong>
                                                                    Questão {!! $question->order !!}
                                                                </strong>
                                                                <p style="margin-left: 70px; margin-top: 7px; margin-bottom: 0;">{!! nl2br($question->note) !!}
                                                                </p>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Variável para conter o arquivo classroom.css do gulp -->
    <script type="text/javascript">
        var css = '<link rel="stylesheet" media="all" href=<?php echo elixir('css/classroom.css');?> type="text/css">';
    </script>
    <!--  -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@endsection






