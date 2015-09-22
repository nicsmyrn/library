<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Photo;
use App\Models\Item;
use App\Models\Product;
use App\Repositories\Library\AjaxBookRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Events\BookHasCreated;

use App\Http\Requests;
use App\Http\Requests\BookRequest;

use App\Repositories\Library\DbBookRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class BooksController
 * @package App\Http\Controllers
 */
class BooksController extends Controller
{
    /**
     * @var DbBookRepository
     */
    protected $book;
    /**
     * @var AjaxBookRepository
     */
    protected $ajax;

    /**
     * @param DbBookRepository $bookRepository
     * @param AjaxBookRepository $ajaxRepository
     */
    public function __construct(DbBookRepository $bookRepository, AjaxBookRepository $ajaxRepository){
        $this->middleware('acl:create_book',['only'=>['index','create','store','edit', 'update','ajaxSearchISBN']]);
        $this->book = $bookRepository;
        $this->ajax = $ajaxRepository;
        parent::__construct();
    }
    /**
     * Display all books that are published and belongs to organization
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $books = $this->user->organization->products->where('is_type', 'App\Models\Book');
        return view('frontend.library.book.index', compact('books'));
    }

    public function unpublished()
    {
        $books = $this->user->organization->unpublished->where('is_type', 'App\Models\Book');
        return view('frontend.library.librarian.index-unpublished', compact('books'));
    }

    public function editUnpublished(Product $product)
    {
        return view('frontend.library.librarian.edit-unpublished', $this->book->editUnpublished($product));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('frontend.library.book.create_book', $this->book->varLists());
    }

    /**
     * Store a newly created book in storage.
     *
     * @param  BookRequest  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(BookRequest $request)
    {
        $this->book->create($request);
        event(new BookHasCreated(
            'Δημιουργία βιβλίου: '.$request->title,
            Carbon::now()->format('Y-m-d'),
            'http://library.gr/cPanel/unpublished/'.$request->get('barcode').'/confirm',
            $this->user->myAdministratorHash(),
            $request->get('barcode'),
            1
        ));
        flash()->overlay('Συγχαρητήρια', 'το βιβλίο '.$request->title.' δημιουργήθηκε με επιτυχία. Αναμένετε έγκριση από τον διαχειριστή');
        return redirect()->back();
    }


    /**
     * Display the specified book.
     *
     * @param  Product $product
     * @return \App\Models\Product
     */
    public function show(Product $product)
    {
        return $product;
    }


    /**
     * Show the form for editing the specified book.
     *
     * @param  Product $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('frontend.library.book.edit_book', $this->book->editPreparation($product));
    }


    // Το ISBN, ο τίτλος και ότι ανήκει στο Product & Book Model πρέπει να πάρει έγκριση από τον διαχειριστή
    // Δ Ε Ν   Ε Χ Ε Ι    Γ Ι Ν Ε Ι  Α Κ Ο Μ Α
    /**
     * Update the specified book in storage.
     *
     * @param BookRequest|Request $request
     * @param Product $product
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(BookRequest $request, Product $product)
    {
        $this->book->update($request, $product);
        flash()->overlay('Συγχαρητήρια', 'το βιβλίο ενημερώθηκε με επιτυχία', 'info');
        return redirect()->back();
    }

    /**
     * Add Photo Cover to a book instance
     *
     * @param Request $request
     * @param $barcode
     * @return string
     */
    public function addPhotos(Request $request, $barcode)
    {
        $this->validate($request,[
           'photo' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);

        $photo = $this->makePhoto($request->file('photo'),'cover');

        Product::where('barcode', $barcode)->firstOrFail()
            ->addPhoto($photo);

        return 'done';
    }

    protected function makePhoto(UploadedFile $file, $type)
    {
        $photo =  Photo::named($file->getClientOriginalName(), $type);
        $photo->move($file);

        return $photo;
    }


    /**
     * Ajax call for update favorite column
     *
     * @param Request $request
     * @return array
     */
    public function updateTableActions(Request $request)
    {
        if ($request->get('action') == 'favorite') {
            $item = Item::findOrFail($request->get('book-id'));
            $favorite = !$item->favorite;
            $item->update(['favorite' => $favorite]);
            if ($item->favorite) {
                $data['sweetalert'] = [
                    'title' => 'το βιβλίο προστέθηκε στα Αγαπημένα',
                    'level' => 'success'
                ];
            } else {
                $data['sweetalert'] = [
                    'title' => 'το βιβλίο ΔΕΝ ανήκει πλέον στα Αγαπημένα',
                    'level' => 'info'
                ];
            }
            $data['itemId'] = $item->id;
            $data['itemFavorite'] = $item->favorite;
        }elseif($request->get('action')== 'delete'){
            $item = Item::findOrFail($request->get('book-id'));
            if($item->delete()) {
                $data['sweetalert'] = [
                    'title' => 'το βιβλίο Διεγράφηκε...',
                    'level' => 'success'
                ];
            }
        }
        return $data;
    }

    public function ajaxDeleteItem(Request $request)
    {
//        $item = Item::findOrNew(1);
    }

    /**
     * Remove the specified book from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Ajax call for searching if the isbn exists
     *
     * @return array
     */
    public function ajaxSearchISBN(){
        return $this->ajax->searchISBN();
    }

    /**
     * Ajax call for getting the subcategory
     *
     * @return array
     */
    public function ajaxGetSubCategory(){
        return $this->ajax->getSubCategory();
    }

    /**
     * Ajax call for getting BookCode
     *
     * @return array
     */
    public function ajaxGetBookCode(){
        return $this->ajax->getBookCode();
    }

    /**
     * Ajax call for adding new author
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxAddNewAuthor(Request $request){
        return $this->ajax->addNewAuthor($request);
    }

    /**
     * Ajax call for adding new editor
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxAddNewEditor(Request $request){
        return $this->ajax->addNewEditor($request);
    }

    /**
     * Ajax call for creating the 4th category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxCreate4category(Request $request){
        return $this->ajax->create4category($request);
    }

}





















































