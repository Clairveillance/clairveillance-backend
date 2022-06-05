<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users\Traits;

use App\Core\Requests\Api\V1\Users\IndexRequest;

trait HasRelationships
{
    protected function getMorphOneRelationships(IndexRequest $request): array
    {
        return [
            'profile' => (array)$request->validated()['profile'],
        ];
    }

    protected function getHasManyRelationships(IndexRequest $request): array
    {
        return [
            'posts' => (array)$request->validated()['posts'],
        ];
    }

    protected function getMorphToManyRelationships(IndexRequest $request): array
    {
        return [
            'appointables' => (array)$request->validated()['appointables'],
            'assemblables' => (array)$request->validated()['assemblables'],
            'assignables' => (array)$request->validated()['assignables'],
            'establishables' => (array)$request->validated()['establishables'],
        ];
    }

    protected function getMorphToManyRelationshipsHasProfile(IndexRequest $request): array
    {
        return [
            'appointables_has_profile' => (array)$request->validated()['appointables_has_profile'],
            'assemblables_has_profile' => (array)$request->validated()['assemblables_has_profile'],
            'assignables_has_profile' => (array)$request->validated()['assignables_has_profile'],
            'establishables_has_profile' => (array)$request->validated()['establishables_has_profile'],
        ];
    }
}
