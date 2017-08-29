@extends('frontend.layouts.master-classroom')

@section('content')
    <section role="main" class="content-body">

        <header class="page-header">
            <h2 class="title-header" >MANUAL DO ALUNO</h2>
        </header>

    <div class="container">
            <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" onclick="javascript: window.history.back();"></i>&nbsp;&nbsp;VOLTAR&nbsp;&nbsp;</button>

        <BR>
        <BR>
            <div class="row">
                <embed src="/BRJ_Fase_2_OAB_Manual_do_Aluno.pdf" width="100%" height="700" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
            </div>
    </div>


</section>



@endsection