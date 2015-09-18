<!-- GROUP FIELD ISBN -->
<div class="row" id="row_isbn">
    <div class="col-md-3">
        <!-- Isbn Form Input -->
        <div class="form-group" id="div_isbn">
            @if(isset($book))
                <h4>ISBN: <span class="label label-default">{!! $book->isbn !!}</span></h4>
            @else
                {!! Form::label('isbn', 'ISBN:', ['class'=>'control-label']) !!}
                <span id="isbn_error" class="text-danger"></span>
                {!! Form::text('isbn',null, ['class'=>'form-control', 'autocomplete'=>'off', 'id'=>'isbn']) !!}
            @endif

        </div>
    </div>
    <div class="col-md-5" id="isbn_message"></div>
</div>

<!-- GROUP FIELD TITLE -->
<div class="row" id="row_titles">
    <div class="col-md-7">
        <!-- Title Form Input -->
        <div class="form-group" id="div_title">
            {!! Form::label('title', 'Τίτλος:', ['class'=>'control-label']) !!}
            {!! Form::text('title',null, ['class'=>'form-control','id'=>'title','autocomplete'=>'off']) !!}
        </div>

        <!-- Subtitle Form Input -->
        <div class="form-group" id="">
            {!! Form::label('subtitle', 'Υπότιτλος:', ['class'=>'control-label']) !!}
            @if(isset($book))
                {!! Form::text('subtitle',$book->subtitle, ['class'=>'form-control', 'placeholder'=>'Προαιρετικό']) !!}
            @else
                {!! Form::text('subtitle',null, ['class'=>'form-control', 'placeholder'=>'Προαιρετικό']) !!}
            @endif
        </div>
    </div>
    <div class="col-md-5">
        <!-- GROUP FIELD PHOTO -->
        @if(isset($product) && $product->photos)
            <div class="row" id="row_photo">
                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-body">
                             {!!Form::label('image', 'Φωτογραφία Εξωφύλλου')!!}<br>
                             <img src="{!! asset($product->photocover) !!}" alt="something"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-5"></div>
            </div>
        @endif
    </div>
</div>

<!-- GROUP FIELD AUTHORS -->
<div class="row" id="row_authors">
    <div class="col-md-7">
        <!-- Authors Form Input -->
        <div class="form-group" id="">
            {!! Form::label('author-list[]', 'Συγγραφείς:', ['class'=>'control-label']) !!}
            {!! Form::select('author-list[]',$authors,isset($bookauthors)?$bookauthors:null, ['class='=>'form-control', 'id'=>'authors', 'multiple']) !!}
            <a class="add-new-object" id="author-add" href="#" data-toggle="modal" data-target="#author_modal"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>
        </div>
    </div>
</div>

<!-- GROUP FIELD CATEGORIES -->
<div class="row" id="row_categories">
    <div class="col-md-7">
        @include('frontend.library.book._form_categories')
    </div>
    <div class="col-md-5">
         <div class="form-group">
            @include('frontend.library.book._form_bookcode')
        </div>
        <div class="form-group">
            @include('frontend.library.book._form_dewey')
        </div>
    </div>
</div>

<!-- GROUP FIELD EDITOR - YEAR -->
<div class="row" id="row_editor">
    <div class="col-md-7">
        <!-- FIELD EDITOR -->
        <div class="form-group">
            {!! Form::label('e_id', 'Εκδότης', ['class'=>'control-label']) !!}
            {!! Form::select('e_id',$editors, isset($book->editor->id)?$book->editor->id:null, ['class='=>'form-control', 'id'=>'editor']) !!}
            <a class="add-new-object" id="editor-add" href="#" data-toggle="modal" data-target="#editor_modal"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>
        </div>
    </div>
    <div class="col-md-5"></div>
</div>

<div class="row" id="row_year">
    <div class="col-md-4">
        <!-- Year Form Input -->
        <div class="form-group" id="div_year">
            {!! Form::label('year', 'Χρονολογία Έκδοσης:', ['class'=>'control-label']) !!}
            <span id="year_error" class="text-danger"></span>
            {!! Form::text('year',isset($book->year)?$book->year:null, ['class'=>'form-control', 'id'=>'year']) !!}
        </div>
    </div>
    <div class="col-md-5"></div>
</div>

<!-- GROUP FIELD SERIES -->
{{--<div class="row" id="row_series">--}}
    {{--<div class="col-md-7">--}}
        {{--<div class="panel panel-info">--}}
            {{--<div class="panel-body">--}}
                {{--{!! Form::label('series', 'Ανήκει σε κάποια σειρά;', ['class'=>'control-label']) !!}--}}
                {{--{!! Form::checkbox('series', null, null,['class'=>'checkbox-inline lg']) !!}--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}
    {{--<div class="col-md-5">--}}
    {{--</div>--}}
{{--</div>--}}


<!-- GROUP FIELD TAGS -->
<div class="row" id="row_tags">
    <div class="col-md-7">
        <!-- Tags Form Input -->
        <div class="form-group" id="">
            {!! Form::label('tag-list[]', 'Ετικέτες:', ['class'=>'control-label']) !!}
            {!! Form::select('tag-list[]',$tags,isset($itemtags)?$itemtags:null, ['class='=>'form-control', 'id'=>'tags', 'multiple']) !!}
        </div>
    </div>
</div>

<!-- GROUP FIELD DESCRIPTION -->
<div class="row" id="row_description">
    <div class="col-md-7">
        {!! Form::label('description', 'Περιγραφή',['class'=>'control-label']) !!}
        {!! Form::textarea('description', isset($book->description)?$book->description:null, ['class'=>'form-control']) !!}
    </div>
    <div class="col-md-5"></div>
</div>
<hr>
<!-- GROUP FIELD QUANTITY AND SUBMIT BUTTON -->
<div class="row" id="row_submit">
    <div class="col-md-4">
        <!-- Quantity Form Input -->
        <div class="form-group" id="div_quantity">
            {!! Form::label('quantity', 'Ποσότητα:', ['class'=>'control-label']) !!}
            <span id="quantity_error" class="text-danger"></span>
            {!! Form::text('quantity',isset($item->quantity)?$item->quantity:null, ['class'=>'form-control','id'=>'quantity', 'required']) !!}
        </div>
    </div>
    <div class="col-md-5">
        {!! Form::submit($submitButton,['class'=>'btn btn-primary btn-lg']) !!}
    </div>
</div>
