<?php

namespace App\Repositories\Library;

use DB;

class UnpublishedRepository{

    public function index()
    {
        return DB::table('products')
            ->join('items','items.product_id','=', 'products.id')
            ->join('organizations', 'items.organization_id', '=', 'organizations.id')
            ->where('items.published', 0)
            ->get();
    }

}

