<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        return response()->json(
            data: null,
            status: 201
        );
    }
}
