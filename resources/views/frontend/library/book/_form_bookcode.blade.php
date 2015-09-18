    @if(isset($product))

        <div class="panel panel-primary" id="book-code">
            <div class="panel-heading text-center">
                ΚΩΔΙΚΟΣ ΒΙΒΛΙΟΥ
            </div>
            <div class="panel-body">
                <h4 class='text-center' style='letter-spacing: 0.2em'>
                    <span class='label label-default'>

                        {!! $product->barcode !!}

                    </span>
                </h4>
            </div>
        </div>

    @else

        <div class="panel panel-default" id="book-code">
            <div class="panel-heading">
                Εδώ θα εμφανιστεί ο κωδικός του βιβλίου
            </div>
        </div>

    @endif