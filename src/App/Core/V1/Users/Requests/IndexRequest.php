<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Requests;

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
        // For example, we probably want to block access to some requests if the user is not authenticated nor has an appropriate role.
        return (array) [
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
                'min:1',
                'max:100',
            ],
            'appointables' => [
                'nullable',
            ],
            'appointables.*' => [
                'nullable',
                'in:show,count,unpublished',
            ],
            'appointables_has_profile' => [
                'nullable',
            ],
            'appointables_has_profile.*' => [
                'nullable',
                'in:show,count,unpublished',
            ],
            'assemblables' => [
                'nullable',
            ],
            'assemblables.*' => [
                'nullable',
                'in:show,count,unpublished',
            ],
            'assemblables_has_profile' => [
                'nullable',
            ],
            'assemblables_has_profile.*' => [
                'nullable',
                'in:show,count,unpublished',
            ],
            'assignables' => [
                'nullable',
            ],
            'assignables.*' => [
                'nullable',
                'in:show,count,unpublished',
            ],
            'assignables_has_profile' => [
                'nullable',
            ],
            'assignables_has_profile.*' => [
                'nullable',
                'in:show,count,unpublished',
            ],
            'establishables' => [
                'nullable',
            ],
            'establishables.*' => [
                'nullable',
                'in:show,count,unpublished',
            ],
            'establishables_has_profile' => [
                'nullable',
            ],
            'establishables_has_profile.*' => [
                'nullable',
                'in:show,count,unpublished',
            ],
            'posts' => [
                'nullable',
            ],
            'posts.*' => [
                'nullable',
                'in:show,count,unpublished',
            ],
            'profile' => [
                'nullable'
            ],
            'profile.*' => [
                'nullable',
                'in:show,unpublished',
            ],
        ];
    }

    // NOTE: By default HTTP requests are formatted as string.
    // We use prepareForValidation() method to force type hint on validator inputs.
    protected function prepareForValidation(): void
    {
        $this->merge([
            'order_by' =>
            (string) $this->order_by === '' ?
                'username' :
                (string) $this->order_by,
            'order_direction' =>
            (string) $this->order_direction === '' ?
                'asc' :
                (string) $this->order_direction,
            'per_page' =>
            (int) $this->per_page === 0 ?
                25 :
                (int) $this->per_page,
            'appointables' =>
            isset($this->appointables) ?
                explode(',', $this->appointables) :
                null,
            'appointables_has_profile' =>
            isset($this->appointables_has_profile) ?
                explode(',', $this->appointables_has_profile) :
                null,
            'assemblables' =>
            isset($this->assemblables) ?
                explode(',', $this->assemblables) :
                null,
            'assemblables_has_profile' =>
            isset($this->assemblables_has_profile) ?
                explode(',', $this->assemblables_has_profile) :
                null,
            'assignables' =>
            isset($this->assignables) ?
                explode(',', $this->assignables) :
                null,
            'assignables_has_profile' =>
            isset($this->assignables_has_profile) ?
                explode(',', $this->assignables_has_profile) :
                null,
            'establishables' =>
            isset($this->establishables) ?
                explode(',', $this->establishables) :
                null,
            'establishables_has_profile' =>
            isset($this->establishables_has_profile) ?
                explode(',', $this->establishables_has_profile) :
                null,
            'posts' =>
            isset($this->posts) ?
                explode(',', $this->posts) :
                null,
            'profile' =>
            isset($this->profile) ?
                explode(',', $this->profile) :
                null,
        ]);
    }

    public function messages(): array
    {
        return (array) [
            'order_by.in' => "Available values: 'id', 'username', 'firstname', 'lastname', 'email', 'created_at' or 'updated_at'.",
            'order_direction.in' => "Available values: 'asc' or 'desc'.",
            'per_page.min' => "Only a minimum of 1 and a maximum of 100 is allowed.",
            'per_page.max' => "Only a minimum of 1 and a maximum of 100 is allowed.",
            'profile.*.in' => "Available values: 'show' and/or 'unpublished'.",
            '*.*.in' => "Available values: 'show', 'count' and/or 'unpublished'",
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
