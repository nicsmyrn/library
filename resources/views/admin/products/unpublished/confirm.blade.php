@extends('admin.dashboard')

@section('header')
    <div class="text-center"> Επιβεβαίωση για Δημοσίευση Προϊόντος </div>
@endsection

@section('content')
    <div class="text-center">
        <a href="{!! route('Admin::Unpublished::delUnProduct',[$product->barcode]) !!}" class="btn btn-danger">Διαγραφή</a>
        <a href="{!! route('Admin::Unpublished::publishUnProduct', [$product->barcode]) !!}" class="btn btn-success">Δημοσίευση</a>
    </div>

    <hr>
    <div class="container">
        <div class="col-md-8">
            <div class="jumbotron">
                    <p>ISBN:<strong>{!! $product->is->isbn !!}</strong></p>
                    <p>Τίτλος:<strong>{!!$product->title !!}</strong></p>
                    <p>Υπότιτλος: <strong>{!! $product->is->subtitle!!}</strong></p>
                    <p>Συγγραφείς:</p>
                        <ul>
                            @foreach($authors_list as $author)
                                <li><strong>{!! $author !!}</strong></li>
                            @endforeach
                        </ul>
                    <p>Κατηγορία: <strong>{!! $category->name !!}</strong></p>
                    <p>Barcode: <strong>{!!$product->barcode !!}</strong></p>
                    <p>Κωδικός Dewey: <strong>{!! $product->organizations->first()->pivot->dewey_code!!}</strong></p>
                    <p>Εκδότης: <strong>{!! $editor !!}</strong></p>
                    <p>Χρονολογία: <strong>{!! $product->is->year!!}</strong></p>
                    <p>Περιγραφή: <strong>{!!$product->is->description !!}</strong></p>
                    <p>Ποσότητα: <strong>{!! $product->organizations->first()->pivot->quantity!!}</strong></p>
            </div>
        </div>
    </div>
@endsection
