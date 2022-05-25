<?php

declare(strict_types=1);

namespace Domain\User\ValueObjects;

final class UserValueObject
{
    public function __construct(
        public string $username,
        public string $firstname,
        public string $lastname,
        public ?string $description,
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
            'description' => $this->description,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
