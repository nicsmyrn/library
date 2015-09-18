
    @if(isset($item))

        <div class="panel panel-primary" id="dewey-code">

            <div class="panel-heading text-center">
                Ταξινόμηση Dewey
            </div>

            <div class="panel-body">
                <h4 class='text-center' style='letter-spacing: 0.2em'>
                    <span class='label label-default'>

                        {!! $item->dewey_code !!}

                    </span>
                </h4>
                {!! Form::hidden('dewey_code', $item->dewey_code) !!}
            </div>

        </div>

    @else

        <div class="panel panel-default" id="dewey-code">

            <div class="panel-heading">
                Εδώ θα εμφανιστεί η ταξινόμηση Dewey
            </div>

        </div>

    @endif