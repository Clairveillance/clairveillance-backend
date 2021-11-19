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
 * @OA\Get(path="/users",
 *   tags={"User"},
 *   summary="Users list.",
 *   description="Display a listing of all users.",
 *   operationId="index",
 *   @OA\Response(response=200, description="Success"),
 *   @OA\Response(response=404, description="Not found"),
 *   @OA\Response(response=422, description="Unprocessable entity"),
 * )
 */
