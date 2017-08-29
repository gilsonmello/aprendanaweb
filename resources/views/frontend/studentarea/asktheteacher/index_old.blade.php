@extends('frontend.layouts.master-classroom')

@section('content')

    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Tira dúvidas</h2>
        </header>
        <!-- start: page -->
        <section class="content-with-menu mailbox">
            <div class="" data-mailbox data-mailbox-view="folder">
                
               
                <div class="inner-body mailbox-folder">
                    <!-- START: .mailbox-header -->
                    <header class="mailbox-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1 class="mailbox-title text-light m-none">
                                    <a id="mailboxToggleSidebar" class="sidebar-toggle-btn trigger-toggle-sidebar">
                                        <span class="line"></span>
                                        <span class="line"></span>
                                        <span class="line"></span>
                                        <span class="line line-angle1"></span>
                                        <span class="line line-angle2"></span>
                                    </a>

                                    Minhas dúvidas
                                </h1>
                                <div class="mailbox-actions" style="padding-left: 0px;">
                                    <ul class="list-unstyled m-none pt-lg pb-lg">
                                        <li class="ib mr-sm">
                                            <a class="item-action fa fa-refresh" href="{{ Route('student.asktheteacher') }}"></a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <b style="color: #D7EEF1; font-size: 5.0rem; padding-top: 10px;">&#8226;</b><b style="font-size: 1.6rem;">Aberta</b>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <b style="color: #DAE9C9; font-size: 5.0rem">&#8226;</b><b style="font-size: 1.6rem;">Respondida</b>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- END: .mailbox-header -->

                    @if (count($asktheteachers) != 0)
                        <table class="table mb-none" style="font-size: 1.5rem;">
                        @foreach ($asktheteachers as $asktheteacher)
                            <tr style="background-color: {{ ( ($asktheteacher->answer != null) ? '#DAE9C9' : '#D7EEF1' ) }}">
                                    <td style="padding-left: 30px;">{!! $asktheteacher->userTeacher != null ? $asktheteacher->userTeacher->name : "Sem professor" !!}</td>
                                    <td>
                                            [<strong>{!! format_datetimebr($asktheteacher->date_question) !!}</strong>]
                                            <br/>
                                            {!! $asktheteacher->question !!}
                                            @if ($asktheteacher->answer != null)
                                            <br/>
                                            <br/>
                                            [<strong>{!! format_datetimebr($asktheteacher->date_answer) !!}</strong>]
                                            <br/>
                                            {!! $asktheteacher->answer !!}
                                            @endif
                                    </td>
                            </tr>
                        @endforeach
                    </table>
                    @else
                        <h4 style="padding: 30px;">Não foi aberto nenhum atendimento ainda.</h4><br/>
                    @endif

                </div>
            </div>
        </section>
        <!-- end: page -->
    </section>

@endsection