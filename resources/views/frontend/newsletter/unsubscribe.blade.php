@extends('frontend.layouts.master')

@section('content')

    <section id="main-content">
        <section class="container">
            <section id="search-meaning">
                <h1>Sair da newsletter</h1>
                <br/>
                <br/>
                    {!! Form::open(['route' => ['newsletters.unsubscribe'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

                        <div class="form-group">
                            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-10">
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.full_name')]) !!}
                            </div>
                        </div><!--form control-->

                        <div class="form-group">
                            {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-10">
                                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
                            </div>
                        </div><!--form control-->

                        <div class="pull-right">
                            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
                        </div>
                        <div class="clearfix"></div>

                    {!! Form::close() !!}

                <br/>
                <br/>
                Caso experimente dificuldade para sair do newsletter, <a href="{{ route('contactus.index') }}">fale conosco</a>.
            </section>

        </section><!-- panel -->

    </section><!-- col-md-10 -->

@endsection