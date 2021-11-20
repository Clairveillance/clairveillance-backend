<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return User::all();
    }
}
