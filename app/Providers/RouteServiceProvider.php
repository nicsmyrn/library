<?php

namespace App\Providers;

use App\Models\Product;
use App\User;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('book', function($barcode){
            return Product::where('barcode', $barcode)->firstOrFail();
        });

        $router->bind('unpublished', function($barcode){
            $product =  Product::with(['organizations'=>function($query){
              $query->find(Auth::user()->organization->id);
            },'is'])
                ->where('barcode', $barcode)
                ->firstOrFail();

            if ($product->organizations->first()->pivot->published == 0){
                return $product;
            }
            return false;
        });

        $router->bind('user', function($hash){
            return User::where('hash', $hash)->first();
        });

    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });

    }
}
