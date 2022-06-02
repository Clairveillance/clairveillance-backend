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
                // 'numeric',
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
        ]);
    }

    public function messages(): array
    {
        return [
            'order_by.in' => "Only allowed values: 'id', 'username', 'firstname', 'lastname', 'email', 'created_at' or 'updated_at'",
            'order_direction.in' => "Only allowed values: 'asc' or 'desc'",
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
