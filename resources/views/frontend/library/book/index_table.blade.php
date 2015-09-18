<table id="books-table" data-toggle="table" data-sort-name="title" data-sort-order="asc" data-pagination="false" data-show-toggle="true" data-search="true" data-toolbar="#toolbar" class="table table-bordered table-striped table-hover" cellspacing="3" cellpadding="3" width="10%" role="grid" style="width: 100%">
    <thead>
        <tr>
            <th data-field="title" data-sortable="true">Τίτλος</th>
            <th data-field="isbn" data-sortable="true">ISBN</th>
            <th>Κωδικός</th>
            <th data-field="dewey" data-sortable="true">Dewey</th>
            <th data-field="quantity" data-sortable="true">Διαθέσιμο</th>
            <th>Ενέργειες</th>
        </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
        @foreach($books as $book)
            <tr data-record="bookcode">
                <td>{!! link_to_action('BooksController@show',$book->title,$book->barcode) !!}</td>
                <td>{!! $book->is->isbn!!}</td>
                <td>{!! $book->barcode!!}</td>
                <td>{!! $book->pivot->dewey_code!!}</td>
                <td>
                @if($book->pivot->available)
                    <span class="label label-success">ΝΑΙ</span>
                @else
                    <span class="label label-default">ΟΧΙ</span>
                @endif
                </td>
                <td class="rowlin-skip">
                    {!! Form::open(['method'=>'POST', 'action' => 'BooksController@updateTableActions', 'data-remote']) !!}

                        <a class="btn btn-warning btn-xs {!! $book->pivot->user_id != Auth::id() ? ' disabled':'' !!}" href="{!! action('BooksController@edit',$book->barcode) !!}" title="Επεξεργασία Βιβλίου"><i class="glyphicon glyphicon-edit"></i> </a>

                        @if($book->pivot->user_id != Auth::id())
                            <button type="button" title="Διαγραφή Βιβλίου" class="btn btn-danger btn-xs disabled"><i class="glyphicon glyphicon-trash"></i> </button>
                        @else
                            <button type="button" title="Διαγραφή Βιβλίου" data-click="delete" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> </button>
                        @endif

                        @if($book->pivot->favorite)
                            <button title="Αγαπημένο βιβλίο" class="btn btn-primary btn-xs" data-click-favorite><i class="glyphicon glyphicon-heart-empty"></i> </button>
                        @else
                            <button title="Αγαπημένο βιβλίο" class="btn btn-xs" data-click-favorite><i class="glyphicon glyphicon-heart-empty"></i></button>
                        @endif
                            {!!Form::hidden('book-id', $book->pivot->id)!!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>