<?php

declare(strict_types=1);

namespace App\Core\V1\Shared\Traits;

use App\Core\V1\Users\Requests\IndexRequest;

trait HasRelationships
{
    protected function getMorphOneRelationships(IndexRequest $request): array
    {
        return (array) [
            'profile' => (array)$request->validated()['profile'],
        ];
    }

    protected function getHasManyRelationships(IndexRequest $request): array
    {
        return (array) [
            'posts' => (array)$request->validated()['posts'],
        ];
    }

    protected function getMorphToManyRelationships(IndexRequest $request): array
    {
        return (array) [
            'appointables' => (array)$request->validated()['appointables'],
            'assemblables' => (array)$request->validated()['assemblables'],
            'assignables' => (array)$request->validated()['assignables'],
            'establishables' => (array)$request->validated()['establishables'],
        ];
    }

    protected function getMorphToManyRelationshipsHasProfile(IndexRequest $request): array
    {
        return (array) [
            'appointables_has_profile' => (array)$request->validated()['appointables_has_profile'],
            'assemblables_has_profile' => (array)$request->validated()['assemblables_has_profile'],
            'assignables_has_profile' => (array)$request->validated()['assignables_has_profile'],
            'establishables_has_profile' => (array)$request->validated()['establishables_has_profile'],
        ];
    }
}
