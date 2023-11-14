<?php

namespace App\Helpers\Crypto;

use App\Helpers\Crypto\Keccak;
use App\Helpers\Crypto\Signature;

class SignatureValidation
{
    /**
     * Check if given signature is valid
     *
     * @param $account
     * @param $signature
     * @param $originalMessage
     * @return bool
     */
    static function isValidSignature($account, $signature, $originalMessage)
    {
        $recoveredAddress = SignatureValidation::recoverSignerAddress($originalMessage, $signature);

        if ($account == $recoveredAddress) {
            return true;
        }
    }

    /**
     *  Return the ETH address of the account that created the signature.
     *
     * @param $msg
     * @param $signed
     * @return string|bool
     */
    static function recoverSignerAddress($msg, $signed)
    {
        // ETH Message Hash
        $prefix             = "\x19Ethereum Signed Message:\n" . strlen($msg);
        $personalMessageSha = Keccak::hash($prefix . $msg, 256);


        // Get r, s, v parameters from signature
        $signatureByteArray      = unpack('C*', hex2bin(substr($signed, 2)));
        $signatureByteArraySplit = array_chunk($signatureByteArray, 32);

        $r = bin2hex(call_user_func_array('pack', array_merge(array('C*'), $signatureByteArraySplit[0])));
        $s = bin2hex(call_user_func_array('pack', array_merge(array('C*'), $signatureByteArraySplit[1])));
        $v = $signatureByteArraySplit[2][0];

        // Check if is correct v value, it should be 27 or 28
        $recovery = $v - 27;
        if ($recovery !== 0 && $recovery !== 1) {
            return false;
        }

        // Recover public key
        $rGmp   = gmp_init('0x' . $r);
        $sGmp   = gmp_init('0x' . $s);
        $msgGmp = gmp_init('0x' . $personalMessageSha);

        $publicKey       = Signature::recoverPublicKey($rGmp, $sGmp, $msgGmp, $recovery);
        $publicKeyString = $publicKey['x'] . $publicKey['y'];

        // Recover ETH address from public key
        $recoveredAddressSha = Keccak::hash(pack('H*', $publicKeyString), 256);
        $recoveredAddress    = substr($recoveredAddressSha, -40);

        return '0x' . $recoveredAddress;
    }
}
