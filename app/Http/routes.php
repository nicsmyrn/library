<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Intervention\Image\Facades\Image;
use App\Events\UserHasRegistered;
use App\Events\BookHasCreated;
use Carbon\Carbon;
use App\Notification;

Route::get('/image',  function(){
    Image::make(file_get_contents(public_path().'/img/books/photos/IMG_0476.jpg'));
    return 'done';
});

Route::get('notices/create/confirm', 'NoticesController@confirm');
Route::resource('notices', 'NoticesController');

Route::get('user', function(){
    return \Auth::user();
});

Route::get('test2', ['middleware'=> 'acl:create_boo', function(){

    return 'This page is only for CREATE books';
}]);


Route::resource('book', 'BooksController');
Route::post('bookActions', 'BooksController@updateTableActions');
Route::post('bookDelete', 'BooksController@ajaxDeleteItem');
Route::post('book/addPhotos/{barcode}', ['as'=>'store_photo_path', 'uses'=>'BooksController@addPhotos']);

Route::controllers([
    'auth' => 'Auth\AuthController'
]);

/*
 * A J A X    -    C A L L S
 */
Route::post('/book/ajax/isbn',['as'=>'book.ajax.isbn','uses'=>'BooksController@ajaxSearchISBN']);
Route::post('/book/ajax/showSubCategory', ['as'=>'book.ajax.categories','uses'=>'BooksController@ajaxGetSubCategory']);
Route::post('/book/ajax/create4category', ['as'=>'book.ajax.4category', 'uses'=>'BooksController@ajaxCreate4category']);
Route::post('/book/ajax/ShowBookCode', ['as'=>'book.ajax.bookcode','uses'=>'BooksController@ajaxGetBookCode']);
Route::post('/book/ajax/addNewAuthor', ['as'=>'book.ajax.addAuthor', 'uses'=>'BooksController@ajaxAddNewAuthor']);
Route::post('/book/ajax/addNewEditor', ['as'=>'book.ajax.addEditor', 'uses'=>'BooksController@ajaxAddNewEditor']);

Route::get('/book/categories/recursion/{cat_id}', 'BooksController@getCategoriesByRecursion');




Route::get('users', ['uses'=>'UserController@index']);

Route::get('date', function(){
    return Auth::user()->myAdministratorHash();
});

Route::get('broadcast', function(){
    $request = Request::create('/', 'GET', [
        'first_name' => 'test',
        'last_name' => 'test',
        'username' => 'test',
        'email' => 'test@gmail.com',
        'password' => bcrypt('1453'),
        'role_id' => 1,
        'org_id' => 1
    ]);
DB::beginTransaction();
    $user = \App\User::create($request->all());
    $collection = $user->with('role')->where('id',$user->id)->get();
    event(new UserHasRegistered($collection));

//    event(new UserHasRegistered($user));

    return 'done';
});

//Route::get('temp', function(){ return view('admin.users.temp');});
//Route::get('broadcast2', function(){
////    event(new BookHasCreated('This is the new notification', time(), 'http://www.google.gr', Auth::user()->hash));
//    event(new BookHasCreated(
//        'Δημιουργία βιβλίου',
//        Carbon::now()->format('d-m-Y'),
//        'http://library.gr/cPanel/products/6988045D0D/edit',
//        Auth::user()->myAdministratorHash()
//    ));
//    return 'done';
//});

Route::get('notifications', function(){
    $notifications =  Auth::user()->adminNotifications();
    return $notifications;
});

Route::get('notification/makeRead/{barcode}', function($barcode){  // ΕΧΩ ΑΜΦΙΒΟΛΙΑ ΓΙΑ ΤΟ GET OR POST
    Notification::where('barcode', $barcode)->delete();
});

//Route::get('products/unpublished', ['middleware'=> 'acl:show_my_unpublished','uses'=> 'BooksController@unpublished']);
//Route::get('unpublished/{barcode?}/edit', 'BooksController@editUnpublished');
Route::resource('unpublished','Admin\UnpublishedController');
/*
 * *********************************
 * D A S H B O A R D   R O U T E S *
 * *********************************
 */
Route::group(['prefix'=> 'cPanel', 'as'=> 'Admin::'], function(){
    Route::get('/', ['as'=>'home', 'uses' => 'Admin\AdminController@main']);
    Route::get('cPanel/users-table', ['as'=>'allUsers','uses'=>'Admin\AdminController@allUsers']);

    Route::group(['prefix'=>'unpublished', 'as'=>'Unpublished::'],function(){
        Route::get('/', ['as'=>'index', 'uses'=>'Admin\UnpublishedController@allUnpublished']);
        Route::post('/', ['as' =>'index.post', 'uses' =>'Admin\UnpublishedController@postUnpublished']);
        Route::get('{unpublished}/confirm', ['as'=>'confirmUnpublished','uses'=>'Admin\UnpublishedController@confirmUnpublished']);
        Route::get('{unpublished}/delete', ['as'=>'delUnProduct','uses'=>'Admin\UnpublishedController@deleteProduct']);
        Route::get('{unpublished}/publish',['as'=>'publishUnProduct','uses'=>'Admin\UnpublishedController@publishProduct']);
    });
});

//Route::get('cPanel/login', function(){
//    return view('admin.login');
//});


















