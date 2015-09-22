<?php

namespace App\Repositories\Library;

use App\User;
use DB;

class UnpublishedRepository{

    public function index(User $user)
    {
        return DB::table('products')
            ->join('items','items.product_id','=', 'products.id')
            ->join('organizations', 'items.organization_id', '=', 'organizations.id')
            ->where('items.published', 0)
            ->where('items.organization_id', $user->organization->id)
            ->select(['products.id', 'products.barcode','products.title'])
            ->get();
    }

}

