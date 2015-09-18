@extends('frontend.app')
@section('content')
    <h1 class="page-heading">Όλα τα βιβλία</h1>
    <div class="container">
        @if($books->isEmpty())
                <div class="jumbotron">
                  <h1>Προσοχή!</h1>
                  <p>Ο πίνακας των βιβλίων είναι άδειος...</p>
                </div>
        @else
            @include('frontend.library.book.index_table')
        @endif
    </div>
@stop
@section('footer')
    @include('frontend.library.book.index_footer')
@stop

