@extends('frontend.layouts.master-classroom')

@section('content')

    <header class="page-header">
        <h2>Fale Conosco</h2>
    </header>


    <section role="main" class="content-body">
    <div style="height:15px;"></div>

<div class="row">

<div class="col-md-1"> </div>

    <div class="col-md-3">
        <div class="inbox-sidebar">
            <a href="{{route('student.ticketstudents.create')}}" data-title="Compose" class="btn red compose-btn btn-block">
                <i class="fa fa-edit"></i> Novo Atendimento </a>
            <ul class="inbox-nav">
                <li >
                    <a data-type="open" data-title="Inbox" onclick="javascript: $('.li-mail').css('display', 'block');"> Todos
                        <span class="badge badge-default" id="ticket-count-mail"></span>
                    </a>
                </li>                
                <li >
                    <a data-type="open" data-title="Inbox" onclick="javascript: $('.li-mail').css('display', 'none'); $('.li-not-replied').css('display', 'block');" > Abertos
                        <span class="badge badge-danger" id="ticket-count-mail-not-replied"></span>
                    </a>
                </li>
                <li >
                    <a data-type="reply" data-title="Inbox" onclick="javascript: $('.li-mail').css('display', 'none'); $('.li-replied').css('display', 'block'); "> Respondidos
                        <span class="badge badge-info" id="ticket-count-mail-replied"></span>
                    </a>
                </li>
                <li >
                    <a data-type="close" data-title="Sent" onclick="javascript: $('.li-mail').css('display', 'none'); $('.li-finished').css('display', 'block'); "> Encerrados
                        <span class="badge badge-success" id="ticket-count-mail-finished"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-7">        
    
        <section class="mailbox">
            <div class="" data-mailbox data-mailbox-view="folder">
                
               
                <div class="inner-body mailbox-folder">
                    <!-- START: .mailbox-header -->

                    <!-- END: .mailbox-header -->


                    @if (count($tickets) != 0)
                    <div id="mailbox-email-list" class="mailbox-email-list">

                        <div class="nano">  
                            <div class="lista-Atendimento">
                                <ul class="list-unstyled">
                                    @foreach ($tickets as $ticket)
                                        <li class="li-mail @if ($ticket->is_finished == 1) 
                                                    li-finished
                                                    @elseif ($ticket->is_replied == 1) 
                                                    li-replied
                                                    @else
                                                    li-not-replied
                                                    @endif">
                                            <a  href="{{ route('student.ticketstudents.edit', $ticket->id) }}">
                                                <div class="inbox-nav">
                                                    <span class="badge @if ($ticket->is_finished == 1) 
                                                    badge-success
                                                    @elseif ($ticket->is_replied == 1) 
                                                    badge-info
                                                    @else
                                                    badge-danger
                                                    @endif" >&nbsp;</span>
                                                </div>
                                                <div class="col-sender">
                                                    <p class="m-none ib">{!! str_limit($ticket->sector->name, 20) !!}</p>
                                                </div>
                                                <div class="col-mail">
                                                    <p class="m-none mail-content">
                                                        <span class="subject">{!! strlen($ticket->message) < 220 ? $ticket->message : substr($ticket->message, 0, 220) . '...' !!}</span>
                                                    </p>
                                                    <p class="m-none mail-date">{!! format_datetimebr($ticket->created_at) !!}</p>
                                                </div>
                                            </a>
                                        </li>

                                @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @else
                        <h4 style="padding: 30px;">Não foi aberto nenhum atendimento ainda.</h4><br/>
                    @endif
                </div>
            </div>
        </section>
    </div>


    </div>

<div class="col-md-1"> </div>


        <!-- start: page -->

        <!-- end: page -->
    </section>


@endsection