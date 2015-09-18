<div class="panel panel-default">
    <div class="panel-body" id="div-id-allCategories">

            @if(isset($item))
                <div class="form-group form-inline" id="div-dewey">
                    {!! Form::label('dewey', 'Ανήκει στο σύστημα dewey;', ['class'=>'control-label']) !!}
                    {!! Form::checkbox('dewey',0, $item->category->dewey,[
                        'data-toggle' => 'toggle',
                        'data-style'=>'ios',
                        'data-on'=>'Ναι',
                        'data-off'=>'Όχι',
                        'data-onstyle'=>'warning',
                        'id'=>'dewey']) !!}
                </div>
                @foreach(array_reverse($categories) as $category)
                    <div class="form-group" id="div-categ{!!$category['categID']!!}">
                         {!! Form::label('categ'.$category['categID'], 'Κατηγορία:'.$category['categID']) !!}
                         {!! Form::select('categ'.$category['categID'],$category['category-list'],$category['selected'],['class'=>'book-categories','id'=>'categ'.$category['categID'], 'data-parent-id'=>$category['parent_id']])!!}
                    </div>
                @endforeach

                {!!Form::hidden('numberOfCategories', $category['categID'], ['id'=>'numberOfCategories'])!!}
                {!!Form::hidden('parentID', $category['parent_id'],['id'=>'parentID']) !!}
                {!!Form::hidden('cat_id',$category['id'],['id'=>'categoryID'])!!}
            @else
                <div class="form-group form-inline" id="div-dewey">
                    {!! Form::label('dewey', 'Ανήκει στο σύστημα dewey;', ['class'=>'control-label']) !!}
                    {!! Form::checkbox('dewey',0, true,[
                        'data-toggle' => 'toggle',
                        'data-style'=>'ios',
                        'data-on'=>'Ναι',
                        'data-off'=>'Όχι',
                        'data-onstyle'=>'warning',
                        'id'=>'dewey']) !!}
                </div>

                <!-- Subcategories will be shown here -->
                <div class="form-group" id="div-categ1">
                    {!! Form::label('categ1', 'Κατηγορία:') !!}
                    {!! Form::select('categ1',$categories,null,['class'=>'book-categories','id'=>'categ1'])!!}
                </div>

                {!!Form::hidden('numberOfCategories', Input::old('numberOfCategories'), ['id'=>'numberOfCategories'])!!}
                {!!Form::hidden('parentID', Input::old('parentID'),['id'=>'parentID']) !!}
                {!!Form::hidden('cat_id',Input::old('categoryID'),['id'=>'categoryID'])!!}

            @endif
    </div>
</div>