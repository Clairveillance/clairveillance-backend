<?php

declare(strict_types=1);

namespace App\Core\V1\Shared\Resources\Traits;

trait HasLinks
{
    private array $self;
    private array $parent;

    public function getLinks(): array
    {
        try {
            return [
                'self' => route(
                    name: (string) 'api.' . config('app.api_version') . $this->self['name'],
                    parameters: $this->self['parameters'],
                    absolute: $this->self['absolute'],
                ),
                'parent' => route(
                    name: (string) 'api.' . config('app.api_version') . $this->parent['name'],
                    parameters: $this->parent['parameters'],
                    absolute: $this->parent['absolute']
                ),
            ];
        } catch (\Throwable $e) {
        }
    }

    public function selfLink(
        string $name,
        array|string $parameters = [],
        bool $absolute = true
    ): self {
        $this->self = [
            'name' => $name,
            'parameters' => $parameters,
            'absolute' => $absolute
        ];
        return $this;
    }

    public function parentLink(
        string $name,
        array|string $parameters = [],
        bool $absolute = true
    ): self {
        $this->parent = [
            'name' => $name,
            'parameters' => $parameters,
            'absolute' => $absolute
        ];
        return $this;
    }
}
