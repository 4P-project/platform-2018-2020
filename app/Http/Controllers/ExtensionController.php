<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Helpers\Crypto\SignatureValidation;

class ExtensionController extends Controller
{
    /**
     * Save users public key through AJAX request from browser extension.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function savePublicKey(Request $request)
    {
        $request->validate([
            'wallet'  => 'required|string',
            'publicKey'  => 'required|string',
            'signature' => 'required|string',
        ]);

        if (SignatureValidation::isValidSignature($request->wallet, $request->signature, $request->publicKey)) {
            $user = User::updateOrCreate(
                ['wallet' => $request->wallet],
                ['pub_key' => $request->publicKey]
            );

            if ($user) {
                return response()->json([
                    'success'  => true
                ]);
            }
        }

        return response()->json([
            'error'  => 'Signature is not valid.'
        ]);
    }
}
