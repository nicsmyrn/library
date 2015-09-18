<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    /**
     * The authenticated User
     *
     * @var \App\User|null
     */
    protected  $user;

    /**
     * Is the user signedIn
     *
     * @var \App\User
     */
    protected $signedIn;

    use DispatchesJobs, ValidatesRequests;



    /**
     *Create a new controller instance
     */
    public  function __construct(){
        $this->user = $this->signedIn = \Auth::user();
    }
}
