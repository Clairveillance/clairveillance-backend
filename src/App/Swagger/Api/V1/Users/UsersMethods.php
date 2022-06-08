<?php

declare(strict_types=1);

namespace App\Swagger\Api\V1\Users;


/**
 * 
 * @OA\Get(
 *   path="/users",
 *   tags={"Users"},
 *   summary="Show users list.",
 *   description="Display a listing of all users.
 *     See parameters below.",
 *     @OA\Parameter(
 *          ref="#/components/parameters/UsersParametersOrderBy",
 *     ),
 *     @OA\Parameter(
 *          ref="#/components/parameters/UsersParametersOrderDirection",
 *     ),
 *     @OA\Parameter(
 *          ref="#/components/parameters/UsersParametersPage",
 *     ),
 *     @OA\Parameter(
 *          ref="#/components/parameters/UsersParametersPerPage",
 *     ),
 *     @OA\Parameter(
 *          ref="#/components/parameters/UsersParametersProfile",
 *     ),
 *   @OA\Response(response=200, description="OK"),
 *   @OA\Response(response=403, description="Forbidden"),
 *   @OA\Response(response=404, description="Not Found"),
 *   @OA\Response(response=405, description="Method Not Allowed"),
 *   @OA\Response(response=422, description="Unprocessable Content"),
 *   @OA\Response(response=429, description="Too Many Requests"),
 *   @OA\Response(response=500, description="Internal Server Error")
 * ),
 * 
 * @OA\Get(
 *   path="/users/{uuid}",
 *   tags={"Users"},
 *   summary="Show user data.",
 *   description="Display a specified user.",
 *     @OA\Parameter(
 *         name="uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *           type="string",
 *           maximum=36
 *         )
 *     ),
 *   @OA\Response(response=200, description="OK"),
 *   @OA\Response(response=201, description="Created"),
 *   @OA\Response(response=202, description="Accepted"),
 *   @OA\Response(response=400, description="Bad Request"),
 *   @OA\Response(response=401, description="Unauthorized"),
 *   @OA\Response(response=403, description="Forbidden"),
 *   @OA\Response(response=404, description="Not Found"),
 *   @OA\Response(response=405, description="Method Not Allowed"),
 *   @OA\Response(response=422, description="Unprocessable Content"),
 *   @OA\Response(response=429, description="Too Many Requests"),
 *   @OA\Response(response=500, description="Internal Server Error")
 * )
 */
final class UsersMethods
{
}
