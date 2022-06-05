<?php

declare(strict_types=1);

namespace App\Core\Requests\Api\V1\Users;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

final class IndexRequest extends FormRequest
{
    /** @var string */
    protected $redirectRoute = 'api.v1.users.index';

    // TODO
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // TODO: Add Rule::prohibitedIf() method for certain use cases.
        // For example, we probably want to block access to some requests if the user is not authenticated or depending on his role.
        return [
            'order_by' => [
                'nullable',
                'in:id,username,firstname,lastname,email,created_at,updated_at',
            ],
            'order_direction' => [
                'nullable',
                'in:asc,desc',
            ],
            'per_page' => [
                'nullable',
                'integer',
            ],
            'appointables' => [
                'nullable',
                'array:show,count,published'
            ],
            'appointables.*' => [
                'nullable',
                'boolean'
            ],
            'appointables_has_profile' => [
                'nullable',
                'array:show,count,published'
            ],
            'appointables_has_profile.*' => [
                'nullable',
                'boolean'
            ],
            'assemblables' => [
                'nullable',
                'array:show,count,published'
            ],
            'assemblables.*' => [
                'nullable',
                'boolean'
            ],
            'assemblables_has_profile' => [
                'nullable',
                'array:show,count,published'
            ],
            'assemblables_has_profile.*' => [
                'nullable',
                'boolean'
            ],
            'assignables' => [
                'nullable',
                'array:show,count,published'
            ],
            'assignables.*' => [
                'nullable',
                'boolean'
            ],
            'assignables_has_profile' => [
                'nullable',
                'array:show,count,published'
            ],
            'assignables_has_profile.*' => [
                'nullable',
                'boolean'
            ],
            'establishables' => [
                'nullable',
                'array:show,count,published'
            ],
            'establishables.*' => [
                'nullable',
                'boolean'
            ],
            'establishables_has_profile' => [
                'nullable',
                'array:show,count,published'
            ],
            'establishables_has_profile.*' => [
                'nullable',
                'boolean'
            ],
            'posts' => [
                'nullable',
                'array:show,count,published'
            ],
            'posts.*' => [
                'nullable',
                'boolean'
            ],
            'profile' => [
                'nullable',
                'array:show,published'
            ],
            'profile.*' => [
                'nullable',
                'boolean'
            ],
        ];
    }

    // NOTE: By default HTTP requests are formatted as string.
    // We use prepareForValidation() method to force type hint on validator inputs.
    protected function prepareForValidation(): void
    {
        $this->merge([
            'order_by' => (string) $this->order_by === '' ? 'username' : (string) $this->order_by,
            'order_direction' => (string) $this->order_direction === '' ? 'asc' : (string) $this->order_direction,
            'per_page' => (int) $this->per_page === 0 ? 25 : (int) $this->per_page,
            'appointables' => isset($this->appointables) ? $this->appointables : null,
            'appointables_has_profile' => isset($this->appointables_has_profile) ? $this->appointables_has_profile : null,
            'assemblables' => isset($this->assemblables) ? $this->assemblables : null,
            'assemblables_has_profile' => isset($this->assemblables_has_profile) ? $this->assemblables_has_profile : null,
            'assignables' => isset($this->assignables) ? $this->assignables : null,
            'assignables_has_profile' => isset($this->assignables_has_profile) ? $this->assignables_has_profile : null,
            'establishables' => isset($this->establishables) ? $this->establishables : null,
            'establishables_has_profile' => isset($this->establishables_has_profile) ? $this->establishables_has_profile : null,
            'posts' => isset($this->posts) ? $this->posts : null,
            'profile' => isset($this->profile) ? $this->profile : null,
        ]);
    }

    public function messages(): array
    {
        return [
            'order_by.in' => "Only allowed values: 'id', 'username', 'firstname', 'lastname', 'email', 'created_at' or 'updated_at'",
            'order_direction.in' => "Only allowed values: 'asc' or 'desc'",
            'profile.array' => "Must be an array that contains: 'show' and/or 'published'",
            '*.array' => "Must be an array that contains: 'show', 'count' and/or 'published'",
            '*.*.boolean' => "Must be a boolean value.",
        ];
    }

    // FIXME: Be able to replace attributes with custom names.
    public function attributes(): array
    {
        return [
            // 'order_by' => 'order by',
        ];
    }

    // NOTE: We will use this method if we need to add custom validation hooks.
    public function withValidator(Validator $validator): void
    {
        // $validator->after(
        //     fn (Validator $validator) =>
        //     $validator->errors()
        //         ->add('field', 'Something is wrong with this field!')
        // );
    }

    // NOTE: We will use this method if we need  to add custom validation exceptions.
    // Since we already use custom exceptions Handler, this method is not needed at the moment.
    protected function failedValidation(Validator $validator): void
    {
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
