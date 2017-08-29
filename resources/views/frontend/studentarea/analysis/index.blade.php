@extends('frontend.layouts.master-classroom')

@section('content')

    <section role="main" class="content-body">
        <header class="page-header">
            <div class='row'>
                <div class="col-md-12">
                    <h2><strong>ANÁLISE 360º</strong></h2>
                </div>
            </div>
        </header>

        @include( $analysis )

    </section>
@endsection