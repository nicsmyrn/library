<?php

namespace App\Http\Composers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class NavigationComposer{

    protected $user;

    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
    }

    public function compose(View $view)
    {
        $view->with('user', $this->user);
    }
}