<?php

namespace App\Http\Controllers\Admin;

use App\Events\DeleteUnpublishedNotification;
use App\Models\Organization;
use App\Models\Product;
use App\Repositories\Library\UnpublishedRepository;
use Illuminate\Http\Request;
use App\Models\Category;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UnpublishedController extends Controller
{
    protected $repo;

    public function __construct(UnpublishedRepository $unpublishedRepository){
        $this->repo = $unpublishedRepository;
        parent::__construct();
    }

    public function allUnpublished()
    {
        $products =  $this->repo->index($this->user);
        return view('admin.products.unpublished.all', compact('products'));
    }

    public function postUnpublished(Request $request)
    {
        $action = $request->get('action');
        $ids = $request->get('id');

        if ($action == 'delete'){
            foreach($ids as $id){
                $this->deleteProduct(Product::find($id));
            }
            flash()->success('Διεγράφη', 'Το προϊόν Διεγράφη με επιτυχία');
        }elseif($action == 'publish'){
            foreach($ids as $id){
                $this->publishProduct(Product::find($id));
            }
            flash()->success('Δημοσιεύθη', 'Το προϊόν δημοσιεύθηκε  με επιτυχία');
        }
        return redirect()->back();
    }

    public function confirmUnpublished(Product $product)
    {
        $authors_list =  $product->is->authors->lists('lastname');
        $category =  Category::where('id', $product->organizations->first()->pivot->cat_id)->first(['name']);
        $editor =  $product->is->editor->e_name;

        return view('admin.products.unpublished.confirm', compact('product', 'authors_list', 'category', 'editor'));
    }

    public function publishProduct(Product $product)
    {
            $product->publish();
            event(new DeleteUnpublishedNotification($product->barcode));
            flash()->success('Δημοσιεύτηκε!');
            return redirect()->route('Admin::Unpublished::index');
    }

    public function deleteProduct(Product $product)
    {
        event(new DeleteUnpublishedNotification($product->barcode));

        if ($product->countOrganizations == 1){
            $product->delete();
        }else{
            $product->organizations()->detach($this->user->organization->id);
        }

        flash()->info('Διεγράφη','το συγκεκριμένο προϊόν διεγράφη με επιτυχία από τον Οργανισμό');
        return redirect()->route('Admin::Unpublished::index');
    }

}
