<?php

declare(strict_types=1);

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Clairveillance",
 *         description="Clairveillance API Documentation.",
 *         @OA\License(
 *             name="MIT",
 *             url="https://github.com/Clairveillance/clairveillance-backend/blob/master/LICENSE.md"
 *         )
 *     ),
 * ),
 *
 * @OA\Server(
 *   description="Version 1",
 *   url=L5_SWAGGER_CONST_API_V1
 * ),
 *
 * @OA\Get(path="/users",
 *   tags={"Users"},
 *   summary="Show users list.",
 *   description="Display a listing of all users.",
 *   @OA\Response(response=200, description="Success"),
 *   @OA\Response(response=422, description="Unprocessable entity")
 * ),
 *
 * @OA\Get(path="/users/{uuid}",
 *   tags={"Users"},
 *   summary="Show user data.",
 *   description="Display a specified user.",
 *     @OA\Parameter(
 *         name="uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *           type="string"
 *         )
 *     ),
 *   @OA\Response(response=200, description="Success"),
 *   @OA\Response(response=404, description="Not found"),
 *   @OA\Response(response=422, description="Unprocessable entity")
 * )
 */