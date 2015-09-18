<?php

namespace App\Repositories\Library;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Input;
use App\Models\Product;
use App\Models\Author;
use Illuminate\Support\Str;
use App\Models\Editor;

class AjaxBookRepository{

    public function searchISBN(){
        if (\Request::ajax()){
            $data = array();

            $isbn = \Input::get('isbn');

            if (is_numeric($isbn)){
                $book = Book::where('isbn', $isbn)->first();

                if ($book){
                    $product = \Auth::user()->organization->products->find($book->id);

                    if ($product){ // το βιβλίο υπάρχει στον οργανισμό και μπορούμε να το κάνουμε μόνο EDIT
                        $data['find'] = true;
                        $data['id'] = $book->id;
                        $data['title'] = $book->product->title;
                        $data['barcode'] = $book->product->barcode;
                        $data['notify'] = '<p>Το βιβλίο με το συγκεκριμένο ISBN <strong> υπάρχει ήδη. </strong> </p> <p>Μπορείτε να το τροποποιήσετε κάνοντας κλικ στον τίτλο:</p>';
                    }else{ // το βιβλίο υπάρχει σε άλλον οργανισμό και μπορούμε να το προσθέσουμε μόνο ως item
                        $data['find'] = true;
                        $data['external'] = true;
                        $data['id'] = $book->id;
                        $data['title'] = $book->product->title;
                        $data['barcode'] = $book->product->barcode;
                        $data['notify'] = '<p>Το βιβλίο με το συγκεκριμένο ISBN είναι καταχωρημένο από άλλο οργανισμό. Θέλετε να το προσθέσετε?</p>';
                    }
                }// else σημαίνει ότι όλα ΟΚ για create_book
            }

            return $data;
        }// END If
    }

    public function getSubCategory(){
        if (\Request::ajax()){
            $option_value = \Input::get('value') == 'null' ? '' : \Input::get('value'); // Το Value του option του combobox
            $parent = \Input::get('parent');//το Id του τρέχων combobox
            $dewey = \Input::get('dewey'); //ελέγχει αν το checkbox είναι true ή false
            $child = \Input::get('child');
            $parentID = \Input::get('parentID');

            if (!isset($parentID)){
                $parentID = '';
            }

            $data = array();

            if ($dewey == 'true'){ // εαν το checkbox dewey είναι ΝΑΙ τότε
                $sql_dewey = 1;

                $data['select'] = Category::where('dewey', $sql_dewey)
                    ->where('parent_id',$option_value)
                    ->where('level', $child)
                    ->get()->lists('name_cat', 'cat_id');   // τα δεδομένα του combobox

                $selectRecord = Category::where('dewey', $sql_dewey)
                    ->where('parent_id',$option_value)
                    ->where('level', $child)
                    ->first();

                if ($selectRecord){
                    $data['parentID'] = $selectRecord->parent_id;
                }


                if ($parent > 0){ //εαν έχει επιλεγεί κάποιο combobox με dewey να είναι ΝΑΙ (ενεργοποιημένο) τότε
                    $record = Category::where('cat_id', $option_value)
                        ->where('parent_id', $parentID)
                        ->where('level', $parent)
                        ->where('dewey', $sql_dewey)
                        ->first();                  //επιστρέφει το ID της κατηγορίας
                    $data['categoryID'] = $record->id;

                }                                   // διαφορετικά δεν επιστρέφει categoryID
            }else{                                  // αλλιώς αν το dewey είναι ΟΧΙ - false - ΑΠΕΝΕΡΓΟΠΟΙΗΜΕΝΟ τοτε
                $sql_dewey = 0;

                $data['select'] = Category::where('dewey', $sql_dewey)
                    ->where('level', $child)
                    ->get()->lists('name_cat', 'cat_id');       // επιστρέφει το combobox με δεδομένα

                if ($parent > 0){                // εαν έχει επιλεγεί κάποιο combobox τότε
                    $record = Category::where('cat_id', $option_value)
                        ->where('level', $parent)
                        ->where('dewey', $sql_dewey)
                        ->first();                  // επιστρέφει το ID της κατηγορίας διαφορετικά τίποτα
                    $data['categoryID'] = $record->id;
                    $data['parentID'] = $record->parent_id;
                }
            }

            $data['sub'] = $child;
            $data['value_option'] = $option_value;

            return $data;

        }
    }

    public function getBookCode(){
        if (\Request::ajax()){
            $data = array();

            $isbn = Input::get('isbn');
            $deweycode = Input::get('dewey_code');

            $bookcode = strtoupper(substr(md5($isbn.$deweycode),0,10));


            $isNotUnique = Product::where('barcode', $bookcode)->get();

            if (!$isNotUnique->isEmpty()){
                do{
                    $bookcode = strtoupper(substr(md5($isbn.$deweycode.microtime()),0,10));
                    $isNotUnique = Product::where('barcode', $bookcode)->get();
                }while(!$isNotUnique->isEmpty());
            }else{
                $data['bookcode'] = $bookcode;
            }

            $data['bookcode'] = $bookcode;

            return $data;
        }
    }

    public function addNewAuthor($request){
        $data = array();
        $rules = [
            'firstname' => 'alpha',
            'lastname' =>  'required|min:3|alpha'
        ];

        $messages = [
            'lastname.required' => 'Το επώνυμο του συγγραφέα είναι υποχρεωτικό',
            'lastname.min' => 'Το επώνυμο του συγγραφέα  πρέπει να είναι τουλάχιστον 3 χαρακτήρες',
            'lastname.alpha' => 'Το επώνυμο του συγγραφέα  πρέπει να είναι Αγγλικοί ή Ελληνικοί χαρακτήρες',
            'firstname.alpha' => 'Το όνομα του συγγραφέα πρέπει να είναι Αγγλικοί ή Ελληνικοί χαρακτήρες'
        ];

        if ($request->ajax()){
            $validator = \Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){
                return \Response::json($validator->errors()->all(),422);
            }else{
                $author = Author::create([
                    'lastname'=>Str::upper($request->get('lastname')),
                    'firstname'=>Str::upper($request->get('firstname'))
                ]);

                if($author){
                    $data['sweetalert'] = [
                        'title' => 'Συγχαρητήρια',
                        'body' => 'ο συγγραφέας προστέθηκε με επιτυχία',
                        'level' => 'success'
                    ];
                    $data['author']['lastname'] = $author->lastname;
                    $data['author']['firstname'] = $author->firstname;
                    $data['author']['id'] = $author->id;
                }else{
                    $data['sweetalert'] = [
                        'title' => 'Πρόβλημα',
                        'body' => 'ο συγγραφέας ΔΕΝ  αποθηκεύτηκε...',
                        'level' => 'error'
                    ];
                }

                return \Response::json($data);
            }
        }
    }

    public function addNewEditor($request){
        $data = array();
        $rules = [
            'name' => 'required|min:3|alpha'
        ];

        $messages = [
            'name.required' => 'Το όνομα είναι υποχρεωτικό',
            'name.min' => 'Το όνομα του εκδότη πρέπει να είναι τουλάχιστον 3 χαρακτήρες',
            'name.alpha' => 'Το όνομα του εκδότη πρέπει να είναι Αγγλικοί ή Ελληνικοί χαρακτήρες'
        ];

        if ($request->ajax()){
            $validator = \Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){
                return \Response::json($validator->errors()->all(),422);
            }else{
                $editor = Editor::create(['e_name'=> Str::upper($request->get('name'))]);

                if($editor){
                    $data['sweetalert'] = [
                        'title' => 'Συγχαρητήρια',
                        'body' => 'ο εκδότης προστέθηκε με επιτυχία',
                        'level' => 'success'
                    ];
                    $data['editor']['name'] = $editor->e_name;
                    $data['editor']['id'] = $editor->id;
                }else{
                    $data['sweetalert'] = [
                        'title' => 'Πρόβλημα',
                        'body' => 'ο εκδότης ΔΕΝ  αποθηκεύτηκε...',
                        'level' => 'error'
                    ];
                }
                return \Response::json($data);
            }
        }
    }

    public function create4category($request){
        $data = array();
        $rules = [
            'level' => 'required',
            'dewey' => 'required|boolean',
            'type' => 'required|integer',
            'cat_id' => array('required' , 'regex:/^\d+$/'),
            'name' => 'required|min:3',
            'parent_id' => 'required',
            'dataoption' => 'required'
        ];

        $messages = [
            'level.required' => 'το :attribute είναι υποχρεωτικό',
            'dewey.required'=> 'το :attribute είναι υποχρεωτικό',
            'dewey.boolean' => 'ναι ή όχι',
            'type.required'=> 'το :attribute είναι υποχρεωτικό',
            'type.integer' => 'το :attribute πρέπει να είναι αριθμός',
            'cat_id.required'=> 'το :attribute είναι υποχρεωτικό',
            'cat_id.regex' => 'το αναγνωριστικό της κατηγορίας πρέπει να είναι μόνο αριθμητικά ψηφία',
            'name.required' => 'το όνομα της κατηγορίας είναι υποχρεωτικό',
            'name.min' => 'το όνομα της κατηγορίας πρεπει να είναι τουλάχιστον 3 χαρακτήρες',
            'parent_id.required'=> 'το :attribute είναι υποχρεωτικό',
            'dataoption.required'=> 'το :attribute είναι υποχρεωτικό'
        ];

        if ($request->ajax()){
            $validator = \Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){
                return \Response::json($validator->errors()->all(),422);
            }else{
                if ($request->get('dataoption') == 'not_exist'){
                    $optionExist = false;
                }elseif($request->get('dataoption') == 'exist') {
                    $optionExist = true;
                }

                $category4 = Category::create($request->all());

                if($category4){
                    $data['sweetalert'] = [
                        'title' => 'Συγχαρητήρια',
                        'body' => 'η κατηγορία προστέθηκε με επιτυχία',
                        'level' => 'success'
                    ];
                    $data['category4']['name'] = $category4->name;
                    $data['category4']['option-value'] = $category4->cat_id;
                    $data['category4']['parentID'] = $category4->parent_id;
                    $data['category4']['id'] = $category4->id;
                }else{
                    $data['sweetalert'] = [
                        'title' => 'Πρόβλημα',
                        'body' => 'η κατηγορία ΔΕΝ  αποθηκεύτηκε...',
                        'level' => 'error'
                    ];
                }
                $data['category4']['option-exist'] = $optionExist;
                return \Response::json($data);
            }
        }
    }
}