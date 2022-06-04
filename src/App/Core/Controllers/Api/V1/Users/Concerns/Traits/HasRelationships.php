<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users\Concerns\Traits;

use App\Core\Requests\Api\V1\Users\IndexRequest;

trait HasRelationships
{
    protected function getMorphOneRelationships(IndexRequest $request): array
    {
        return [
            'profile' => $request->validated()['profile'],
        ];
    }

    protected function getHasManyRelationships(IndexRequest $request): array
    {
        return [
            'posts' => (bool)$request->validated()['posts'],
        ];
    }

    protected function getMorphToManyRelationships(IndexRequest $request): array
    {
        return [
            'appointables' => (bool)$request->validated()['appointables'],
            'assemblables' => (bool)$request->validated()['assemblables'],
            'assignables' => (bool)$request->validated()['assignables'],
            'establishables' => (bool)$request->validated()['establishables'],
        ];
    }

    protected function getMorphToManyRelationshipsHasProfile(IndexRequest $request): array
    {
        return [
            'appointables_has_profile' => (bool)$request->validated()['appointables_has_profile'],
            'assemblables_has_profile' => (bool)$request->validated()['assemblables_has_profile'],
            'assignables_has_profile' => (bool)$request->validated()['assignables_has_profile'],
            'establishables_has_profile' => (bool)$request->validated()['establishables_has_profile'],
        ];
    }
}
