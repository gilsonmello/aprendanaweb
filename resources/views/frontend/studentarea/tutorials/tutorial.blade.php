@extends('frontend.layouts.master-classroom')

@section('content')
    <section role="main" class="content-body">

        <header class="page-header">
            <h2 class="title-header" >TUTORIAIS</h2>
        </header>

    <div class="container">
            <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" onclick="javascript: window.history.back();"></i>&nbsp;&nbsp;VOLTAR&nbsp;&nbsp;</button>

            <div class="row">
                <h3 style="color: #444"><strong>| Apresentação Geral</strong> da Plataforma&nbsp;&nbsp;
                <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" data-toggle="collapse" data-target="#video1"></i>&nbsp;&nbsp;VER&nbsp;&nbsp;</button></h3>
                <div id="video1" class="collapse col-md-8">
                    <div class="entry-header">
                        <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/193101485" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>

        <div class="row">
            <h3 style="color: #444"><strong>| Tutorial</strong> para Digitalização das Respostas&nbsp;&nbsp;
                <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" data-toggle="collapse" data-target="#video3"></i>&nbsp;&nbsp;VER&nbsp;&nbsp;</button></h3>
            <div id="video3" class="collapse col-md-8">
                <div class="entry-header">
                    <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/195511650" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h3 style="color: #444"><strong>| Tutorial</strong> de Oficinas&nbsp;&nbsp;
                <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" data-toggle="collapse" data-target="#video4"></i>&nbsp;&nbsp;VER&nbsp;&nbsp;</button></h3>
            <div id="video4" class="collapse col-md-8">
                <div class="entry-header">
                    <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/193101520" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h3 style="color: #444"><strong>| Orientações</strong> para o Simulado Premium&nbsp;&nbsp;
                <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" data-toggle="collapse" data-target="#video5"></i>&nbsp;&nbsp;VER&nbsp;&nbsp;</button></h3>
            <div id="video5" class="collapse">
                <div class="entry-header col-md-8">
                    <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/193101473" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h3 style="color: #444"><strong>| Tutorial</strong> de orientação para correção&nbsp;&nbsp;
                <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" data-toggle="collapse" data-target="#video6"></i>&nbsp;&nbsp;VER&nbsp;&nbsp;</button></h3>
            <div id="video6" class="collapse">
                <div class="entry-header col-md-8">
                    <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/193536567" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>




</section>

@endsection