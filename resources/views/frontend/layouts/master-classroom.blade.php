<!doctype html>
<html class="fixed sidebar-light sidebar-left-sm  sidebar-left-collapsed header-light">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}" />
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'O Brasil Jur�dico � Ensino de Alta Performance � uma institui��o de ensino que nasceu com o fiel prop�sito e o compromisso �tico de oferecer aos seus alunos e � toda comunidade jur�dica do pa�s um conte�do did�tico arrojado e de excel�ncia, com m�todos e recursos modernos, indispens�veis ao crescimento profissional.')">
        <meta name="author" content="@yield('author', 'Brasil Jur�dico')">
        @yield('meta')
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

        {!! HTML::style('css/plugin/select2.min.css') !!}
        {!! HTML::style('css/plugin/datepicker3.css') !!}
        {!! HTML::style('css/plugin/bootstrap3-wysihtml5.min.css') !!}
        @yield('before-styles-end')
        {!! HTML::style(elixir('css/classroom.css')) !!}
        @yield('after-styles-end')

        



    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        {{--@include('frontend.includes.nav')--}}

        <!-- div principal -->
       
        <section class="body">
            <div id="scroll-top">
                <span style="line-height: 1.5; font-weight: bold;" title="voltar ao topo">
                    &nbsp;&nbsp;^&nbsp;&nbsp;
                </span>
            </div>

        @include(get_classroom_header())
        {{--@include('frontend.includes.classroom-header')--}}

        <div class="inner-wrapper">
                {{--@include('frontend.includes.classroom-sidebar')--}}


                @yield('content')

            @include('frontend.studentarea.requestfailure')
        </div>
        <!-- ./div principal -->









            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            <script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>
            <script src="https://player.vimeo.com/api/player.js"></script>
        {!! HTML::script('js/vendor/bootstrap.min.js') !!}
        {!! HTML::script('js/vendor/select2.full.min.js') !!}
        {!! HTML::script('js/vendor/bootstrap3-wysihtml5.all.min.js') !!}
        {!! HTML::script('js/vendor/bootstrap-datepicker.js') !!}
        {!! HTML::script('js/vendor/inputmask.js') !!}
        {!! HTML::script('js/vendor/jquery.inputmask.js') !!}
        {!! HTML::script('js/vendor/jquery.maskMoney.js') !!}
        {!! HTML::script('js/vendor/inputmask.extensions.js') !!}




        @yield('before-scripts-end')
        {!! HTML::script(elixir('js/classroom.js')) !!}
        @yield('after-scripts-end')

        @include('includes.partials.ga')

        <!-- begin olark code -->
        <script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
                f[z]=function(){
                    (a.s=a.s||[]).push(arguments)};var a=f[z]._={
                },q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
                    f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
                    0:+new Date};a.P=function(u){
                    a.p[u]=new Date-a.p[0]};function s(){
                    a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
                    hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
                    return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
                    b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
                    b.contentWindow[g].open()}catch(w){
                    c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
                    var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
                    b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
                loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
            /* custom configuration goes here (www.olark.com/documentation) */
            olark.identify('4322-602-10-9480');/*]]>*/</script><noscript><a href="https://www.olark.com/site/4322-602-10-9480/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
        <!-- end olark code -->

    </body>
</html>
