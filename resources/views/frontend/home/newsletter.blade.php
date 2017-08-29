<div id="section">
    <div class="container">
        <div class="space small"></div>
        <div class="row">
            <div class="col-md-6">
                <h2>Assine nossa newsletter</h2>
            </div>
            <div class="col-md-6">
                <div class="space small"></div>
                {!! Form::open(array('route' => array('newsletters.subscribe'), 'method' => 'post','class' => 'form-inline'))  !!}
                <div class="form-group">
                    <input type="name" class="form-control"  name="name" placeholder="Seu Nome">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Seu E-mail">
                </div>
                <button type="submit" class="btn btn-primary">ENVIAR</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div><!--/.container-->
</div><!--/.section-->
