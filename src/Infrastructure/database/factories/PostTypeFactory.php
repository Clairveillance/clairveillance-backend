<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Models\Post\PostType;
use Database\Factories\Concerns\AbstractTypeFactory;

final class PostTypeFactory extends AbstractTypeFactory
{
    protected $model = PostType::class;
}
