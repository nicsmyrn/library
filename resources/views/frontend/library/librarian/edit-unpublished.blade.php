@extends('frontend.app')


@section('title')
    Επεξεργασία Βιβλίου - Unpublished
@stop


@section('content')
    <h1 class="page-heading">Επεξεργασία Βιβλίου που ΔΕΝ έχει δημοσιευτεί</h1>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    @include('errors.list')
                    {!! Form::model($product,['method'=>'PATCH','action'=>['BooksController@update',$product->barcode]]) !!}
                        @include('frontend.library.book._form', ['submitButton'=>'Αποθήκευση βιβλίου'])
                    {!! Form::close() !!}
                    <hr>
                    {!! Form::open([
                            'id'=>'addPhotoForm',
                            'action'=>['BooksController@addPhotos', $product->barcode],
                            'method'=>'POST',
                            'class'=>'dropzone'
                    ]) !!}
                    {!! Form::close() !!}
                </div>
                <div class="panel-footer">
                    Επεξεργασία Βιβλίου
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    @include('frontend.library.book.modals.modal_newAuthor')
    @include('frontend.library.book.modals.modal_newEditor')
    @include('frontend.library.book.modals.modal_4category')
@endsection

@section('links.header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@endsection

@section('scripts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
    <script>
        Dropzone.options.addPhotoForm = {
            paramName : 'photo',
            maxFileSize : 2,
            acceptedFiles : '.jpg, .jpeg, .png, .bmp',
            dictDefaultMessage : 'Πατήστε ή σύρετε το ποντίκι εδώ για να ανεβάσετε το εξώφυλλο'
        };
    </script>
@endsection

@section('footer')
    @include('frontend.library.book._form_edit_footer')
@stop