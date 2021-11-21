<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
            ],
            'firstname' => [
                'required',
                'string',
                'max:255',
            ],
            'lastname' => [
                'required',
                'string',
                'max:255',
            ],
            'avatar' => [
                'nullable',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:65535',
            ],
            'company' => [
                'nullable',
                'string',
                'max:255',
            ],
            'website' => [
                'nullable',
                'string',
                'max:255',
            ],
            'country' => [
                'required',
                'string',
                'max:255',
            ],
            'state' => [
                'nullable',
                'string',
                'max:255',
            ],
            'city' => [
                'nullable',
                'string',
                'max:255',
            ],
            'zip' => [
                'nullable',
                'string',
                'max:255',
            ],
            'address' => [
                'nullable',
                'string',
                'max:255',
            ],
            'address_2' => [
                'nullable',
                'string',
                'max:255',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:255',
            ],
            'theme' => [
                'nullable',
                'string',
                'max:255',
            ],
            'language' => [
                'nullable',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
