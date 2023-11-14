<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerKycFormRequest;
use Illuminate\Http\Request;
use App\UserKyc;
use Illuminate\Routing\Controller as BaseController;


class UserkycsController extends BaseController
{
    protected $adminRoute;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin')->except('store');
        $this->adminRoute = env('ADMIN_ROUTE', 'admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CustomerKycFormRequest
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerKycFormRequest $form)
    {
        $form->persist();

        return redirect('account/verify')->with('message',
            'Kyc form submited successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserKyc $kyc)
    {
        return view('admin.kycforms.view', compact('kyc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status'  => 'required|integer',
            'message' => 'sometimes|string',
        ]);

        $kyc = UserKyc::find($id);

        if ($status = $request->input('status', false)) {
            $kyc->status = $status;
        }

        if ($message = $request->input('message', false)) {
            $kyc->message = $message;
        }

        $kyc->save();

        return redirect()->action('AdminController@pending')->with('message',
            'Kyc form saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filterdata(Request $request)
    {
        $query    = UserKyc::query();
        $allCount = UserKyc::all()->count();

        $sort  = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $query->orderBy($sort, $order);

        if ($status = $request->input('status', false)) {
            $query->where('status', $status);
            $allCount = UserKyc::all()->where('status', $status)->count();
        }

        if ($offset = $request->input('offset', false)) {
            $query->offset($offset);
        }

        if ($limit = $request->input('limit', false)) {
            $query->limit($limit);
        }

        $pendingKycs = $query->get()->values();

        return response()->json([
            'total' => $allCount,
            'rows'  => $pendingKycs->values(),
        ]);
    }
}
