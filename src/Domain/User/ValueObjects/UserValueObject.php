<?php

declare(strict_types=1);

namespace Domain\User\ValueObjects;

class UserValueObject
{
    public function __construct(
        public string $username,
        public string $firstname,
        public string $lastname,
        public null|string $avatar = null,
        public null|string $description = null,
        public string $company,
        public null|string $website = null,
        public string $country,
        public null|string $state = null,
        public null|string $city = null,
        public null|string $zip = null,
        public null|string $address = null,
        public null|string $address_2 = null,
        public null|string $phone = null,
        public null|string $theme = null,
        public null|string $language = null,
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
