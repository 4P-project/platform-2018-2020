<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \App\UserKyc;

class CustomerKycFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'account_type'               => 'required',
            'company_name'               => 'required',
            'registered_office'          => 'required',
            'business_address'           => 'required',
            'registration_number'        => 'required',
            'name_of_the_representative' => 'required',
            'country_code'               => 'required',
            'tax_id_number'              => 'required',
            'email'                      => 'required|email',
            'phone_number'               => 'required',
        ];

        return $rules;
    }

    /**
     *  Save validated object to database
     *
     */
    public function persist()
    {
        $data = $this->only([
            'account_type',
            'status',
            'company_name',
            'registered_office',
            'business_address',
            'registration_number',
            'name_of_the_representative',
            'country_code',
            'tax_id_number',
            'email',
            'phone_number',
        ]);


        $data['user_id'] = auth()->user()->id;
        $data['status']  = UserKyc::STATUS_PENDING;

        UserKyc::updateOrCreate(['user_id' => auth()->user()->id], $data);
    }
}
