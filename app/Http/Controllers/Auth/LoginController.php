<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Helpers\Crypto\SignatureValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Events\Registered;
use \Junaidnasir\Larainvite\Facades\Invite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Store the error
     *
     * @var string
     */
    protected $error = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if ($this->validateSignature($request)) {

            // Try to login user
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }

            // Try to register user with this address
            if ($this->register($request)) {
                return $this->sendLoginResponse($request);
            } else {

                $this->error = 'There is a problem with user registration.';
            }
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request signature from web3 provider.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function validateSignature(Request $request)
    {
        $msg = config('app.sign_message');

        if (SignatureValidation::isValidSignature($request->account, $request->signed, $msg)) {
            return true;
        }

        $this->error = 'There is a problem with validating your signature.';

        return false;
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(['wallet' => $request->account]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ? : redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'wallet' => $data['account'],
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'auth'  => auth()->check(),
            'error' => $this->error,
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'wallet';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $kyc = $user->kyc;
        if ($kyc
            && $kyc->account_type == \App\UserKyc::KYC_FORM_TYPE_CORPORATE
            && $kyc->status == \App\UserKyc::STATUS_CONFIRMED
        ) {
            $request->session()->put('is_corporate', true);
        } else {
            $request->session()->put('is_corporate', false);
        }

        // Add employe to company
        $code = $request->cookie('einvite');
        if($code && Invite::isValid($code)) {
            $invitation = Invite::get($code);
            Invite::consume($code);
            \App\UserEmployee::create(['user_id' => $invitation->user_id, 'employee_id' => $user->id, 'status' => true]);
            \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('einvite'));
        }

        if ($request->ajax()) {
            return response()->json([
                'auth'     => auth()->check(),
                'intended' => url($this->redirectPath()),
            ]);
        }
    }
}
