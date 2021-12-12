<?php

declare(strict_types=1);

namespace Domain\User\ValueObjects;

final class UserValueObject
{
    public function __construct(
        public string $username,
        public string $firstname,
        public string $lastname,
        public ?string $avatar = null,
        public ?string $description = null,
        public string $company,
        public ?string $website = null,
        public string $country,
        public ?string $state = null,
        public ?string $city = null,
        public ?string $zip = null,
        public ?string $address = null,
        public ?string $address_2 = null,
        public ?string $phone = null,
        public ?string $theme = null,
        public ?string $language = null,
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
