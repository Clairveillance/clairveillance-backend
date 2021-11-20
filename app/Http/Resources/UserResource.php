<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            $this::$wrap => parent::toArray($request),
            'links' => [
                'self' => route('api.v1.user.show', $this->id),
                'parent' => route('api.v1.users.index'),
            ]
        ];
    }

    public static $wrap = 'user';
}
