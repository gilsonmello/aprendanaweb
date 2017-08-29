@extends('frontend.layouts.master')

@section('content')
    <div class="container">
        <div class="content">
            <div class="container">
                <div class="space"></div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="row">
                            <div class="title">{{ trans('strings.system_error') }}</div>
                        </div>
                        <br/>
                        <div class="row" >
                            <div class="col-md-3"></div>
                            <div class="col-md-6" style="background-color: white">
                                {{ $exception->getMessage()  }}
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <br/>
                        <div class="row">

                            <a href="{{URL::previous()}}" class="btn btn-danger">Voltar</a>

                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div>
        </div>
    </div>
@endsection