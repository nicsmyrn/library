<?php

namespace App\Repositories\Library;

use App\Models\Item;
use App\Models\Book;
use App\Models\Author;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Editor;

class DbBookRepository{

    public function varLists(){
        $itemtags = null;
        $authors = Author::get()->lists('full_name', 'id');
        $editors = [''=>''] +Editor::lists('e_name', 'id')->all();
        $tags = Tag::lists('tag_name', 'id');

        $categories = [''=>''] + Category::where('level',1)->where('dewey',1)->get()->lists('name_cat', 'cat_id')->all();

        return compact('itemtags', 'authors', 'editors', 'tags', 'categories');
    }

    public function create($request){
        \DB::beginTransaction();
            $user = \Auth::user();
            $book = Book::create($request->all());

            $book->product()->create($request->all());

            $book->product->organizations()->attach($user->organization->id, [
                'dewey_code' => $request['dewey_code'],
                'quantity' => $request['quantity'],
                'cat_id' => $request['cat_id'],
                'user_id' => $user->id,
                'edited_by' => $user->id
            ]);

            $book->authors()->attach($request['author-list']);

            $item = Item::find($book->product->orgcreate()->first()->pivot->id);

            $item->tags()->attach($request['tag-list']);
        \DB::commit();
    }

    public function editPreparation($product){
        $item =  Item::find($product->organizations->first()->pivot->id);
        $itemtags = $item->tags->lists(['id'])->toArray();
        $book = $product->is;
        $bookauthors = $book->authors->lists(['id'])->toArray();
        $categories = $this->getCategoriesByRecursion($item->cat_id);

        $authors = Author::get()->lists('full_name', 'id');
        $editors = [''=>''] +Editor::lists('e_name', 'id')->all();
        $tags = Tag::lists('tag_name', 'id');

        return compact(
            'product',
            'itemtags',
            'authors',
            'editors',
            'categories',
            'tags',
            'book',
            'item',
            'bookauthors',
            'categories'
        );
    }

    /**
     * Updates all book metadata
     *
     * @param $request
     * @param $product
     */
    public function update($request, $product){
        \DB::beginTransaction();
            $product->is->update($request->all());

            $product->is->authors()->sync($request['author-list']);

            $product->update($request->all());

            $item = Item::find($product->organizations()->first()->pivot->id);
            $item->update($request->all());

            if($request['tag-list']){
                $item->tags()->sync($request['tag-list']);
            }else{
                $item->tags()->detach();
            }
        \DB::commit();
    }


    private function getCategoriesByRecursion($cat_id){   // M A K E   P R I V A T E FUNCTION

        $record = Category::find($cat_id);
        $dewey = $record->dewey;

        $i=$record->level;

        for($i; $i>=1 ; $i--){
            $recordSet = Category::where('parent_id', $record->parent_id)
                ->where('level',$i)
                ->where('dewey',$dewey)
                ->get()
                ->lists('name_cat', 'cat_id')->all();

            $categoryLists[$i] =  [
                'selected' => $record->cat_id,
                'category-list' => $recordSet,
                'categID' => $record->level,
                'id'=> $record->id,
                'parent_id' => $record->parent_id
            ];

            $record = Category::where('cat_id',$record->parent_id)
                ->where('level', $i-1)
                ->where('dewey',$dewey)
                ->first();
        }

        return $categoryLists;
    }
}