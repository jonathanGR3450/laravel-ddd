<?php

namespace App\UserInterface\Requests\Auth;

use App\UserInterface\Requests\CustomFormRequest;

class RegisterFormRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'identification' => 'required|numeric',
            'type_document_id' => 'required|exists:type_documents,id',
            'cell_phone' => 'required|numeric',
            'city' => 'required',
            'address' => 'required',
            'city_register' => 'required',
            'is_manager' => 'required|boolean',
            'is_signer' => 'required|boolean',
            'is_verified' => 'nullable',
            'business_name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'nit' => 'required|numeric',
            'business_address' => 'required',
            'department' => 'required|string|max:255',
            'business_city' => 'required|string|max:255',
            'type_person' => 'required',
            'business_city_register' => 'required',
            'business_email' => 'required|string|email|max:255|unique:business,email',
            'expiration_date' => 'nullable',
        ];
    }
}
