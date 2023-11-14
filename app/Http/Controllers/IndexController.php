<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        return view('frontend.index');
    }
}
