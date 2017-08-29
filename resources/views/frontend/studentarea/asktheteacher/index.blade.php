@extends('frontend.layouts.master-classroom')

@section('content')

    <header class="page-header">
        <h2>Minhas dúvidas</h2>
    </header>


    <section role="main" class="content-body">


<div class="row">

<div class="col-md-1"> </div>

    <div class="col-md-3">
        <div class="inbox-sidebar">
            <ul class="inbox-nav">
                <li >
                    <a data-type="open" data-title="Inbox" onclick="javascript: $('.li-mail').css('display', 'block');"> Todas
                        <span class="badge badge-default" id="ticket-count-mail"></span>
                    </a>
                </li>                
                <li >
                    <a data-type="open" data-title="Inbox" onclick="javascript: $('.li-mail').css('display', 'none'); $('.li-not-replied').css('display', 'block');" > Abertas
                        <span class="badge badge-danger" id="ticket-count-mail-not-replied"></span>
                    </a>
                </li>
                <li >
                    <a data-type="reply" data-title="Inbox" onclick="javascript: $('.li-mail').css('display', 'none'); $('.li-replied').css('display', 'block'); "> Respondidas
                        <span class="badge badge-success" id="ticket-count-mail-replied"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-7">        
    

                    @if (count($asktheteachers) != 0)
                         @foreach ($asktheteachers as $asktheteacher)

                        {{--*/ $teacher = $asktheteacher->userTeacher /*--}}
                        @if ($teacher === null)
                            {{--*/ $teacher = App\User::findOrNew(210) /*--}}
                        @endif

                    <div class="row li-mail @if ($asktheteacher->answer != null)
                                                    li-replied
                                                    @else
                                                    li-not-replied
                                                    @endif">
                        <div class="col-xs-2">
                            <div class="text-right"> <br>
                                @if (($asktheteacher->answer != null) && ($asktheteacher->answer != ''))   
                                <img height="80"  src="{{ imageurl('users/',$teacher->id, $teacher->photo, 100 , 'generic.png',true) }}"
                                     class="img-circle no-padding" data-lock-picture="{{ imageurl('users/',$teacher->id, $teacher->photo, 100 , 'generic.png',true) }}">
                                @else     
                                <img height="80"  src="/img/system/bj_ask.png"
                                     class="img-circle no-padding" data-lock-picture="/img/system/bj_ask.png">
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-10">
                            <div class="card" style="position: relative;">
                            <div class="arrow">
                                <div class="left"></div>
                            </div>

                                
                                <span class="timeline-body-time font-grey-cascade">
                                     Enviada em <strong>{!!  format_datetimebr($asktheteacher->created_at) . ' (' . diff_time( $asktheteacher->created_at ) . ')' !!}</strong>
                                </span>
                                @if (($asktheteacher->answer != null) && ($asktheteacher->answer != ''))   
                                <span class="timeline-body-time font-grey-cascade">                             
                                - Respondida por <strong >{!! $teacher->name !!} </strong> 
                                </span>
                                @endif
                                <div class="p-xs "></div>

                                <span class="font-grey-cascade atendimento-Card-Mensagem"> 
                                   <div style="background-color: #EFF3F8; padding: 15px; border-radius: 10px; border:solid 1px #eee"><strong>{!! nl2br($asktheteacher->question) !!}</strong>
                                   </div>
                                   @if (($asktheteacher->answer != null) && ($asktheteacher->answer != ''))
                                   <div style="border: 2px solid #36c6d3; margin-top: 10px; padding: 15px; border-radius: 10px; ">
                                        <span >{!! nl2br($asktheteacher->answer) !!}</span>
                                    </div>
                                    @else
                                    <div style="border: 2px solid #ed6b75; margin-top: 10px; padding: 15px; border-radius: 10px; ">
                                        <span >Ainda não foi respondida.</span>
                                    </div>  
                                    @endif                                  
                                </span>
                            </div>
                        </div>
                    </div>

                                @endforeach

                    @else
                        <h4 style="padding: 30px;">Não foi aberto nenhuma dúvida ainda.</h4><br/>
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