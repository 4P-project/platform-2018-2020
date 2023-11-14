<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Junaidnasir\Larainvite\Facades\Invite;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * MailController constructor.
     */
    public function __construct()
    {
        $this->errors = new \Illuminate\Support\MessageBag();
    }

    /**
     * Invite employees
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function invite(Request $request)
    {
        $mails = $this->getMailsAsArray($request->get('mails', false));
        if (!$mails) {
            $this->errors->add('no_mails', 'Please insert mails');
            return back()->withErrors($this->errors);
        }

        $countSend = 0;
        foreach ($mails as $mail) {
            $mail = trim($mail);
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $this->errors->add($mail, $mail . ' Invalid email format');
            } else {
                Invite::invite($mail, auth()->user()->id);
                $countSend++;
            }
        }

        return back()->withErrors($this->errors)->with('message',
            $countSend . ' Invitations send!');
    }

    /**
     * Employee invite confirmation
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        $code = $request->get('code', false);
        if (Invite::isValid($code)) {
            /** @var  \Junaidnasir\Larainvite\Models\LaraInviteModel $invitation */
            $invitation = Invite::get($code);

            /** @var  \App\UserKyc $kyc */
            $user = \App\User::where('email', $invitation->email)->get()->first();

            if($user) {
                Invite::consume($code);
                \App\UserEmployee::create(['user_id' => $invitation->user_id, 'employee_id' => $user->id, 'status' => true]);
                return redirect('/')->with('message', 'Invitation accepted!');
            } else {
                return redirect('/')->with('message', 'Please login to confirm invite')->withCookie(cookie('einvite', $code, 525600));
            }
        } else {
            abort(404);
        }
    }

    /**
     * Send email to admin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mailToAdmin(Request $request)
    {
        $request->validate([
            'name'    => 'required|max: 255',
            'email'   => 'required|email|max: 255',
            'subject' => 'required|max: 255',
            'message' => 'required',
        ]);

        Mail::to(env('INFO_EMAIL', 'info@the4thpillar.com'))->send(new \App\Mail\Contact($request->only('name', 'email', 'subject', 'message')));

        return back()->with('message', 'Mail sent successfully!');
    }

    /**
     * Get mails ass array
     *
     * @param string $mails
     * @return array|bool
     */
    protected function getMailsAsArray($mails)
    {
        if ($mails) {
            return explode(',', $mails);
        }

        return false;
    }
}
