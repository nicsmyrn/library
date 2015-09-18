@extends('frontend.app')

@section('title')
    Δημιουργία Βιβλίου
@stop



@section('content')
    <h1 class="page-heading">Νέο Βιβλίο</h1>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Εισαγωγή Νέου Βιβλίου</h3>
                </div>
                <div class="panel-body">
                    @include('errors.list')
                    {!! Form::model($productModel = new App\Models\Product,['action'=>'BooksController@store']) !!}
                        @include('frontend.library.book._form', ['submitButton'=>'Δημιουργία βιβλίου'])
                    {!! Form::close() !!}
                </div>
                <div class="panel-footer">
                    Εισαγωγή Βιβλίου
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    @include('frontend.library.book.modals.modal_newAuthor')
    @include('frontend.library.book.modals.modal_newEditor')
    @include('frontend.library.book.modals.modal_4category')
@stop

@section('links.header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@endsection

@section('scripts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
@endsection

@section('footer')
    @include('frontend.library.book._form_footer')
@stop


