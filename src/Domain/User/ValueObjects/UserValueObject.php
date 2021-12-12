<?php

declare(strict_types=1);

namespace Domain\User\ValueObjects;

final class UserValueObject
{
    public function __construct(
        public string $username,
        public string $firstname,
        public string $lastname,
        public ?string $avatar,
        public ?string $description,
        public string $company,
        public ?string $website,
        public string $country,
        public ?string $state,
        public ?string $city,
        public ?string $zip,
        public ?string $address,
        public ?string $address_2,
        public ?string $phone,
        public ?string $theme,
        public ?string $language,
        public string $email,
        public string $password,
    ) {
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'avatar' => $this->avatar,
            'description' => $this->description,
            'company' => $this->company,
            'website' => $this->website,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'zip' => $this->zip,
            'address' => $this->address,
            'address_2' => $this->address_2,
            'phone' => $this->phone,
            'theme' => $this->theme,
            'language' => $this->language,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
