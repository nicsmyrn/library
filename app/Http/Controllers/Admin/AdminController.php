<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function main()
    {
        return view('admin.main');
    }

    public function allUsers()
    {
        return view('admin.users.users_display');
    }
}
