@extends('frontend.layouts.master')

@section('title')
    Termos de uso | {{app_name()}}
@endsection

@section('content')

 <section id="main-content">
    <div class="container">
        <section id="search-meaning">
            <h1 class="section-title">Termos de Uso</h1>
        </section>
        <br/>
        <div class="row">
          <div class="col-md-12 p-10 font-2">
              @include('frontend.institutional.terms-content')
          </div>

        </div>
    </div>
     <br/>
     <br/>



 </section>
@endsection
