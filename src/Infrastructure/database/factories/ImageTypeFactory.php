<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Eloquent\Models\Image\ImageType;
use Database\Factories\Concerns\AbstractTypeFactory;

final class ImageTypeFactory extends AbstractTypeFactory
{
    protected $model = ImageType::class;
}
