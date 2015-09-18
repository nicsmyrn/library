<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BookRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'create' =>
                [
                    //
                    'isbn' => array('required', 'unique:books,isbn' , 'regex:/^(\d{10}|\d{13})$/'),
                    'title' => 'required|min:3',
                    'image' => 'image',
                    'subtitle' => 'min:3',
                    'barcode' => array('required', 'unique:products,barcode'),
                    'dewey_code' => 'required',
                    'cat_id' => 'required|integer|exists:category,id',
                    'e_id' => 'required|exists:editors,id',
                    'quantity' => 'required|integer|between:1,100',
                    'year' => 'integer|between:1900,'.date("Y",time()),
                    'author-list' => 'required|array|exists:authors,id',
                    'tag-list' => 'array|exists:tags,id',
                    's_id' => 'integer|exists:series,id'
                ],
            'update' => [
                'title' => 'required|min:3',
                'image' => 'image',
                'subtitle' => 'min:3',
                'dewey_code' => 'required',
                'cat_id' => 'required|integer|exists:category,id',
                'e_id' => 'required|exists:editors,id',
                'quantity' => 'required|integer|between:1,100',
                'year' => 'integer|between:1900,'.date("Y",time()),
                'author-list' => 'required|array|exists:authors,id',
                'tag-list' => 'array|exists:tags,id',
                's_id' => 'integer|exists:series,id'
            ]
        ];

        if ($this->method() == 'PATCH'){
            return $rules['update'];
        }elseif($this->method() == 'POST'){
            return $rules['update'];
        }
    }

    /**
     * @return array
     */
    public function messages(){
        $messages=  [
            'isbn.required' => 'Το ISBN είναι υποχρεωτικό',
            'isbn.unique' => 'Το ISBN πρέπει να είναι μοναδικό',
            'isbn.regex' =>  'Το ISBN πρέπει να είναι 10 ή 13 αριθμητικοί χαρακτήρες',
            'title.required' => 'Ο τίτλος του βιβλίου είναι υποχρεωτικός',
            'title.min' => 'Ο τίτλος του βιβλίου πρέπει να περιέχει τουλάχιστον 3 χαρακτήρες',
            'image.image' => 'Το αρχείο  πρέπει να είναι τύπου εικόνας: jpg, jpeg, bmp, png',
            'subtitle.min' => 'Ο υπότιτλος πρέπει να περιέχει τουλάχιστον 3 χαρακτήρες',
            'barcode.required' => 'Ο κωδικός του βιβλίου δεν υπάρχει. Γράψε το ISBN, επέλεξε συγγραφέα και κατηγορία βιβλίου για να δημιουργηθεί',
            'barcode.exists' => 'Ο κωδικός αυτός υπάρχει, ξαναπροσπάθησε',
            'dewey_code.required' => 'Η ταξινόμηση Dewey δεν υπάρχει. Επέλεξε κατηγορία και συγγραφέα για να δημιουργηθεί',
            'cat_id.required' => 'Το βιβλίο πρέπει να ανήκει σε κατηγορία',
            'cat_id.integer' => 'Η κατηγορία πρέπει να είναι αριθμός',
            'cat_id.exists' => 'Η κατηγορία δεν υπάρχει, ξαναπροσπάθησε',
            'e_id.required' => 'Ο εκδότης είναι υποχρεωτικός',
            'e_id.exists' => 'Ο εκδότης ΔΕΝ υπάρχει, ξαναπροσπάθησε',
            'quantity.required' => 'Η ποσότητα είναι υποχρεωτική',
            'quantity.between' => 'Η ποσότητα πρέπει να είναι μεταξύ 1 και 20',
            'year.integer' => 'Η χρονολογία εκδότη πρέπει να είναι ακέραιος αριθμός',
            'year.between' => 'Η χρονολογία εκδότη πρέπει να είναι μεταξύ  1900  και '.date("Y",time()),
            'author-list.required' => 'Ο συγγραφέας είναι υποχρεωτικός',
            'author-list.exists' => 'Ο συγγραφέας ΔΕΝ υπάρχει',
            'tag-list.exists' => 'Η ετικέτες δεν υπάρχουν στη βάση δεδομένων',
            's_id.integer' => 'Η Σειρά πρέπει να είναι αριθμός',
            's_id.exists' => 'Η Σειρά αυτή ΔΕΝ υπάρχει, ξαναπροσπάθησε'
        ];

       return $messages;
    }
}
