<?php

declare(strict_types=1);

namespace Infrastructure\Swagger\Api\V1\Users;


/**
 * 
 * @OA\Parameter(
 *      parameter="UsersParametersOrderBy",
 *      description="Sort results by a particular field. (optional)
 *     When no value is provided, results are sorted by 'username'.",
 *      name="order_by",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          schema="UsersSchemasOrderBy",
 *          type="string", 
 *          enum={"id","username","firstname","lastname","email","created_at","updated_at"},
 *          default="",
 *          example="",
 *      ),
 * ),
 * @OA\Parameter(
 *      parameter="UsersParametersOrderDirection",
 *      description="Sort direction. (optional)
 *     When no value is provided, sort direction is 'asc' (ascending).",
 *      name="order_direction",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          title="Order Direction",
 *          type="string", 
 *          enum={"asc", "desc"},
 *          default="",
 *          example="",
 *     ),
 * ),
 * @OA\Parameter(
 *      parameter="UsersParametersPage",
 *      description="Page number. (optional)
 *     When no value is provided, the first page is displayed.",
 *      name="page",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          format= "int32",
 *          default="",
 *          example="",
 *      ),
 * ),
 * @OA\Parameter(
 *      parameter="UsersParametersPerPage",
 *      description="Number of results to return per page. (optional)
 *     When no value is provided, 25 results are displayed.
 *     For performance reasons, only a maximum of 100 results is allowed.",
 *      name="per_page",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          format= "int32",
 *          maximum="100",
 *          default="",
 *          example="",
 *      ),
 * ),
 * @OA\Parameter(
 *      parameter="UsersParametersProfile",
 *      description="Eager load user profiles. (optional / multiple selection)
 *     When 'show' option is selected, profiles are loaded then displayed.
 *     When both 'show' and 'unpublished' options are selected, only unpublished profiles are displayed.",
 *      name="profile",
 *      in="query",
 *      required=false,
 *      explode=false,
 *      @OA\Schema(
 *          type="array",
 *          default="",
 *          example="",
 *          @OA\Items(
 *          type="string", 
 *          enum={"show", "unpublished"},
 *          ),
 *      ),
 *   ),
 * 
 */
final class UsersParameters
{
}
