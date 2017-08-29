@extends('frontend.layouts.master-classroom')

@section('content')



<section role="main" class="content-body">
    <header class="page-header">
        <h2>Fale Conosco</h2>
    </header>




<div class="row" >
<div class="col-md-1"> </div>
            <div class="col-md-3">
                <div class="inbox-sidebar">
                    <a href="{{route('student.ticketstudents.index')}}" data-title="Compose" class="btn red compose-btn btn-block">
                        <i class="fa fa-inbox"></i> Caixa de Entrada </a>

                    </div>
                </div>

                <div class="col-md-7">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <h1>Qual a sua dúvida ?</h1>
                        </div>

                        <div class="mailbox-folder">


                            <div class="mailbox-email-container">

                                {!! Form::open(['route' => 'student.ticketstudents.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

                                <div class="form-group">
                                    {!! Form::label('sectors', trans('strings.subject'), ['class' => 'col-lg-2 control-label']) !!}
                                    <div class="col-md-12">
                                        {!! Form::select("sectors[]",$sector->lists("name","id"), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_sector') ])  !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('message', trans('validation.attributes.message'), ['class' => 'col-lg-2 control-label']) !!}
                                    <div class="col-md-12">
                                        {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => trans('strings.message')]) !!}
                                    </div>
                                </div>
                                <!--form control-->


                                <div class="pull-left">
                                    <input type="submit" class="btn green" value="{{ trans('strings.send') }}"/>
                                </div> 

                                <div>
                                    &nbsp;&nbsp;<a href="{{route('student.ticketstudents.index', ['page' => Session::get('lastpage', '1')])}}"
                                    class="btn default">{{ trans('strings.cancel_button') }}</a>
                                </div>

                                <div class="clearfix"></div>

                                {!! Form::close() !!}



                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>            <!--  -->


    </div>
<div class="col-md-1"> </div>

    <!-- end: page -->
</section>

@endsection



