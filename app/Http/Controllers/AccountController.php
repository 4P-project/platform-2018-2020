<?php

namespace App\Http\Controllers;

use App\UserEmployee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Braintree_Transaction;

class AccountController extends BaseController
{
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('has_data')->except('update');
    }

    /**
     * Account Dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view('account.dashboard');
    }

    /**
     * User edit form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('account.user.edit')->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage
     *
     * @param User $user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|email',
        ]);

        $data = $request->only('first_name', 'last_name', 'email');
        $user->update($data);

        return redirect('/account')->with('message',
            'Account updated successfully!');
    }

    /**
     * Get public key of wallet address
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPublicKey(Request $request)
    {
        $request->validate([
            'wallet'  => 'required|string'
        ]);

        $user = User::where('wallet', $request->wallet)->first();

        if ($user) {
            return response()->json([
                'public_key'  => $user->pub_key
            ]);
        }

        return response()->json([
            'error'  => 'We can not find public key for given recipient. So we can not encrypt a file.'
        ]);
    }

    /**
     * Verify base view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verify()
    {
        $user = auth()->user();
        $kyc  = $user->kyc;
        return view('account.verify', compact('kyc', 'user'));
    }

    /**
     * Verify personal form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verifyPersonal()
    {
        $documentTypes = \App\UserKyc::getDocumentTypesAsArray();
        return view('account.verify.personal', compact('documentTypes'));
    }

    /**
     * Verify corporate form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verifyCorporate()
    {
        return view('account.verify.corporate')->with(['kyc' => auth()->user()->kyc]);
    }

    /**
     * Form for adding employees to company
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addEmployee()
    {
        return view('account.employee.add');
    }

    /**
     * Employees list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listEmployee()
    {
        $employees = \App\UserEmployee::where('user_id',
            auth()->user()->id)->get();

        return view('account.employee.list', compact('employees'));
    }

    /**
     * Return users employees
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeeAjaxList(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }
        /** @var \Illuminate\Database\Eloquent\Collection $employees */
        $employees = UserEmployee::where('user_id', auth()->user()->id)->get();

        return response()->json(
            $employees->values()
        );
    }

    /**
     * Wallet form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wallet()
    {
        return view('account.wallet');
    }

    /**
     * Api credentials
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apicredentials()
    {
        return view('account.apicredentials');
    }

    /**
     * Buy tokens
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payment()
    {
        return view('account.payment');
    }

    /**
     * See all orders
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders()
    {
        if (auth()->user()->hasBraintreeId()) {
            $invoices = auth()->user()->invoices(true);
        } else {
            $invoices = collect([]);
        }
        return view('account.orders', ['invoices' => $invoices]);
    }
    /**
     * Procces Braintree payment
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processPayment(Request $request)
    {
        $customer = $request->user();
        $payload  = $request->input('payload', false);
        $amount   = $request->input('amount', false);
        $nonce    = $payload['nonce'];

        if (!$customer->braintree_id) {
            $customer->createAsBraintreeCustomer($nonce);
        }

        $status = $customer->invoiceFor('Tokens', $amount);

        return response()->json($status);
    }

    /**
     * Download invoice pdf
     *
     * @param Request $request
     * @param $invoiceId
     * @return mixed
     */
    public function downloadInvoice(Request $request, $invoiceId)
    {
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor'  => 'The4thPillar',
            'product' => 'Invoice'. \Carbon\Carbon::now(),
        ]);
    }
}
