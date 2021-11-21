<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\DeleteRequest;

class DeleteController extends Controller
{
    public function __invoke(DeleteRequest $request)
    {
    }
}
