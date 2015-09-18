@extends('frontend.app')
@section('content')
    <h1 class="page-heading">Βιβλία που ΔΕΝ έχουν δημοσιευτεί</h1>
    <div class="container">
        @if($books->isEmpty())
            <div class="col-md-3"></div>
            <div class="col-md-6">
                    <div class="jumbotron">
                      <p>Δεν υπάρχουν βιβλία που είναι αδημοσίευτα...</p>
                    </div>
            </div>

        @else
            @include('frontend.library.librarian.index-unpublished_table')
        @endif
    </div>
@stop
@section('footer')
    @include('frontend.library.book.index_footer')
@stop