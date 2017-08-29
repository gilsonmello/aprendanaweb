<html>
    <head>
        <meta charset="utf-8">
        <title>Brasil Jurídico</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        {!! HTML::style(elixir('css/website-2017.css')) !!}

    </head>
    <body>
        @include ('frontend.2017.components.topbar')
        <!-- Banner -->
        <div class="brj-home-hero">
            <div class="container">
                <div class="row container">
                    <div class="col-md-5">
                        <h1>Nosso diferencial é o jeito diferente de ensinar</h1>
                        <p>Com o nosso método de ensino você vai conseguir aproveitar muito mais dos seus estudos.</p>
                        <div>
                            <a class="btn-brj btn-brj-primary">TESTE GRÁTIS</a>
                            <a class="btn-brj btn-brj-outline">ASSISTA AO VÍDEO</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="brj-home-courses-content">
            <div class="container"> <!-- Container Cursos - Start -->
                <div class="row">
                    <div class="col-md-9">

                        <!-- Cursos -->

                        <div class="brj-home-header">
                            <div class="brj-home-header-mark mark-orange"></div>
                            <div class="brj-home-header-title">
                                OAB
                            </div>
                            <div class="brj-home-header-paginator">
                                <a class="brj-home-header-paginator-view-all" href="#">VER TODOS</a>
                                <a href="#" class="brj-home-header-paginator-previous--disabled"><i class="material-icons">chevron_left</i></a>
                                <a href="#" class="brj-home-header-paginator-next"><i class="material-icons">chevron_right</i></a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                @include ('frontend.2017.components.course-card')
                            </div>
                            <div class="col-md-4">
                                @include ('frontend.2017.components.course-card')
                            </div>
                            <div class="col-md-4">
                                @include ('frontend.2017.components.course-card')
                            </div>
                        </div>

                    </div>




                    <div class="col-md-3">

                    </div>

                </div>
            </div> <!-- Container Cursos - END -->
        </div>


        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <!-- Notícias -->
                    <div class="brj-home-header">
                        <div class="brj-home-header-mark mark-blue"></div>
                        <div class="brj-home-header-title">
                            Notícias
                        </div>
                        <div class="brj-home-header-paginator">
                            <a class="brj-home-header-paginator-view-all" href="#">VER TODOS</a>
                            <a href="#" class="brj-home-header-paginator-previous--disabled"><i class="material-icons">chevron_left</i></a>
                            <a href="#" class="brj-home-header-paginator-next"><i class="material-icons">chevron_right</i></a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @include ('frontend.2017.components.new-card')
                        </div>
                        <div class="col-md-6">
                            @include ('frontend.2017.components.new-card')
                        </div>
                    </div>
                </div>
                <div class="col-md-3 brj-top-news">
                    <div class="brj-home-top-news-header">NOTÍCIAS EM DESTAQUE</div>
                    @include ('frontend.2017.components.new-card')
                    @include ('frontend.2017.components.new-card')
                </div>
            </div>
        </div>

        <div class="brj-home-catchphrase-content">
            <div class="container">
                <div class="row container">
                    <div class="brj-home-catchphrase clearfix">
                        <div class="brj-home-header-mark mark-blue"></div>
                        <div class="brj-home-catchphrase-title"><h2>Queremos ver você passar!</h2></div>
                        <div class="brj-home-catchphrase-text">Somos mais de <strong>400 professores</strong> preparados para te ajudar a alcançar seus objetivos</div>
                        <div class="brj-home-catchphrase-meet-teachers"><a href="#">CONHEÇA OS PROFESSORES <i class="material-icons">chevron_right</i> </a></div>
                    </div>
                </div>
                <div class="brj-home-catchphrase-quote">
                    <div class="brj-home-catchphrase-quote-image">
                        <img src="https://scontent.fssa2-2.fna.fbcdn.net/v/t1.0-9/13267808_1145167262202068_483849337253415307_n.jpg?oh=bfa3ea7dc854d642eab9859d185859a3&oe=58FE6DB5" alt="" />
                    </div>
                    <div class="brj-home-catchphrase-quote-content">
                        <div class="brj-home-catchphrase-quote-content-quote-text">
                            Você só precisa dar duro e se esforçar … com as aulas interativas, ótimos professores e metodologia diferenciada fica difícil não conseguir alcançar seus objetivos.
                        </div>
                        <div class="brj-home-catchphrase-quote-content-author-name">
                            Carlos Strand
                        </div>
                        <div class="brj-home-catchphrase-quote-content-author-occupation">
                            Analista judiciário do TRE/SP
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="brj-home-catchphrase-teachers"></div>
        <div class="brj-home-payment-methods"></div>        
        @include ('frontend.2017.components.footer')

        <!-- inject:js --><!-- endinject -->
    </body>
</html>
