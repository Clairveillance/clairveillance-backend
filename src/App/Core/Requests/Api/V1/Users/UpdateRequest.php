<?php

declare(strict_types=1);

namespace App\Core\Requests\Api\V1\Users;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // FIXME: Add new rules for username,email. Must be unique if not null.
        return [
            'username' => [
                'nullable',
                'string',
                'max:255',
                // FIXME: There is an issue when authenticated user try to update data.
                // Laravel requires unique email but we dont want to necessarily change this field.
                // We should accept when user resubmit his username without any change.
                // But we still want to prevent the user to modify this field with an already taken username from another user.
                'unique:users,username',
            ],
            'firstname' => [
                'nullable',
                'string',
                'max:255',
            ],
            'lastname' => [
                'nullable',
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
                'nullable',
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
                'nullable',
                'email:rfc,dns',
                'max:255',
                // FIXME: There is an issue when authenticated user try to update data.
                // Laravel requires unique email but we dont want to necessarily change this field.
                // We should accept when user resubmit his email without any change.
                // But we still want to prevent the user to modify this field with an already taken email from another user.
                'unique:users,email',
            ],
            'password' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
