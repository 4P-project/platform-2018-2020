<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class DocumentController extends BaseController
{
    /**
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('has_data')->except('update');
    }

    /**
     * Document index view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.document.index');
    }

    /**
     * Document send view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function send()
    {
        return view('account.document.send');
    }

    /**
     * Save documents uploaded through AJAX request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveFile(Request $request)
    {
        $file           = $request->file('file');
        $uniqueFileName = md5($file->getClientOriginalName() . microtime()) . uniqid() . '.' . $file->getClientOriginalExtension();
        $savedFilePath  = $file->storeAs('documents', $uniqueFileName, 'public');

        return response()->json([
            'success' => 'You have successfully upload file.',
            'fileUrl' => url(Storage::url($savedFilePath)),
        ]);
    }
}
