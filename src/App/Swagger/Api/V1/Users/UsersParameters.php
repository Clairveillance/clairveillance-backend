<?php

declare(strict_types=1);

namespace App\Swagger\Api\V1\Users;


/**
 * 
 * @OA\Parameter(
 *      parameter="UsersParametersOrderBy",
 *      description="Sort results by a particular field. (optional)
 *     When no value is provided, the results will be sorted by 'username'.",
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
 *      description="Sort results direction. (optional)
 *     When no value is provided, the sort direction will be 'asc' (ascending).",
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
 *      parameter="UsersParametersPerPage",
 *      description="Number of results to display per page. (optional)
 *     When no value is provided, 25 results will be displayed per page.
 *     Only a minimum of 1 and a maximum of 100 is allowed.",
 *      name="per_page",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum="1",
 *          maximum="100",
 *          default="",
 *          example="",
 *      ),
 * ),
 * @OA\Parameter(
 *      parameter="UsersParametersProfile",
 *      description="Eager load user profiles. (optional / multiple selection)
 *     When 'show' option is unselected, profiles will not be loaded.
 *     When 'unpublished' option is selected, it will only returns unpublished profiles.",
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
