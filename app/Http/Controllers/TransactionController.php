<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Crypto\RawTxSigner;

class TransactionController extends Controller
{
    /**
     * TransactionController constructor.
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Method sign transaction with 4th pillar private key
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sign(Request $request)
    {
        // Prepare parameters
        $privateKey = $this->removeHexPrefix(config('app.fee_taker_private_key'));

        $nonce    = $this->removeHexPrefix($request->txParams['nonce']);
        $gasPrice = $this->removeHexPrefix($request->txParams['gasPrice']);
        $gasLimit = $this->removeHexPrefix($request->txParams['gasLimit']);
        $to       = $this->removeHexPrefix($request->txParams['to']);
        $value    = '';
        $data     = $this->removeHexPrefix($request->txParams['data']);
        $chainId  = $request->txParams['chainId'];

        // Check if we can sign transaction - if 'to' param is allowable
        if (!$this->isAllowableToParam($to)) {
            return response()->json([
                'error' => 'Not allowable \'to\' param!',
            ]);
        }

        // Get signed hash
        $transaction = new RawTxSigner($nonce, $gasPrice, $gasLimit, $to, $value, $data);
        $raw         = $transaction->getRaw($privateKey, $chainId);

        return response()->json([
            'signedTx' => $raw,
        ]);
    }

    /**
     * Method remove '0x' from left side of the string
     *
     * @param $str
     * @return string
     */
    protected function removeHexPrefix($str)
    {
        return ltrim($str, '0x');
    }

    /**
     * Method checks if is allowable 'to' parameter
     *
     * @param $to
     * @return bool
     */
    protected function isAllowableToParam($to)
    {
        $allowable = [
            $this->removeHexPrefix(config('app.token_contract_address')),
            $this->removeHexPrefix(config('app.document_contract_address')),
        ];

        return in_array($to, $allowable);
    }
}
