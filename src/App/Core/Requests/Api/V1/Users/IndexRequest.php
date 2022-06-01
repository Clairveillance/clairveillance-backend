<?php

declare(strict_types=1);

namespace App\Core\Requests\Api\V1\Users;

use Illuminate\Foundation\Http\FormRequest;

final class IndexRequest extends FormRequest
{
    // TODO: Add custom redirect route for displaying error messages.
    /** @var string */
    protected $redirectRoute = 'api.v1.users.index';

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
                'string',
                'in:id,username,firstname,lastname,email,created_at,updated_at',
            ],
            'order_direction' => [
                'nullable',
                'string',
                'in:asc,desc',
            ],
            'per_page' => [
                'nullable',
                'integer',
                // NOTE: Since we force type hint validators, this option is useless.
                // 'numeric', 
            ],
        ];
    }

    // NOTE: Because HTTP request inputs are formatted as string by default,
    // we use prepareForValidation() method to force type hint validators.
    protected function prepareForValidation(): void
    {
        $this->merge([
            'order_by' => (string)$this->order_by === '' ? 'username' : (string)$this->order_by,
            'order_direction' => (string)$this->order_direction === '' ? 'asc' : (string)$this->order_direction,
            'per_page' => (int)$this->per_page === 0 ? 25 : (int)$this->per_page,
        ]);
    }

    // TODO: Add custom validation messages.
    public function messages(): array
    {
        return [
            // 'order_by.in' => 'A title is required',
        ];
    }
}
