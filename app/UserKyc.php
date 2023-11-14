<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserKyc extends Model
{
    const DOCUMENT_TYPE_PASSPORT         = 1;
    const DOCUMENT_TYPE_DRIVERS_LICENCE  = 2;
    const DOCUMENT_TYPE_NATIONAL_ID_CARD = 3;

    const STATUS_PENDING   = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_ERROR     = 3;

    const KYC_FORM_TYPE_PERSONAL  = 1;
    const KYC_FORM_TYPE_CORPORATE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'account_type',
        'status',
        'tax_number',
        'email',
        'phone_number',
        'company_name',
        'registered_office',
        'business_address',
        'registration_number',
        'name_of_the_representative',
        'tax_id_number',
    ];

    /**
     * Return document types as array
     *
     * @return array
     */
    public static function getDocumentTypesAsArray()
    {
        return [
            self::DOCUMENT_TYPE_PASSPORT         => 'Passport',
            self::DOCUMENT_TYPE_DRIVERS_LICENCE  => 'Drivers license',
            self::DOCUMENT_TYPE_NATIONAL_ID_CARD => 'National ID card',
        ];
    }

    /**
     * Sets parrent class
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
