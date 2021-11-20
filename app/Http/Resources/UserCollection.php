<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

final class UserCollection extends ResourceCollection
{
    public static $wrap = 'data';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'succes' => true,
            'status' => 200,
            $this::$wrap => $this->collection->map(
                function ($item) {
                    return collect([
                        'id' => $item->id,
                        'uuid' => $item->uuid,
                        'username' => $item->username,
                        'firstname' => $item->firstname,
                        'lastname' => $item->lastname,
                        'avatar' => $item->avatar,
                        'description' => $item->description,
                        'company' => $item->company,
                        'website' => $item->website,
                        'country' => $item->country,
                        'state' => $item->state,
                        'city' => $item->city,
                        'zip' => $item->zip,
                        'address' => $item->address,
                        'address_2' => $item->address_2,
                        'phone' => $item->phone,
                        'theme' => $item->theme,
                        'language' => $item->language,
                        'email' => $item->email,
                        'created_at' => null === $item->created_at ? $item->created_at : date('Y-m-d H:i:s', strtotime((string) $item->created_at)),
                        'updated_at' => null === $item->updated_at ? $item->updated_at : date('Y-m-d H:i:s', strtotime((string) $item->updated_at)),
                        'email_verified_at' => null === $item->email_verified_at ? $item->email_verified_at : date('Y-m-d H:i:s', strtotime((string) $item->email_verified_at)),
                        'deleted_at' => null === $item->deleted_at ? $item->deleted_at : date('Y-m-d H:i:s', strtotime((string) $item->deleted_at)),
                        'links' => [
                            'self' => route('api.v1.users.show', $item->id),
                            'parent' => route('api.v1.users.index'),
                        ]
                    ]);
                }
            )
        ];
    }
}
