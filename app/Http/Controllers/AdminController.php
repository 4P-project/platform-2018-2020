<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use \App\UserKyc;
use \Illuminate\Support\Facades\Storage;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function pending()
    {
        $pendingKycs = UserKyc::all()->where('status', UserKyc::STATUS_PENDING);
        return view('admin.kycforms.pending', compact('pendingKycs'));
    }
}
