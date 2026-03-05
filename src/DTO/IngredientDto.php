<?php

namespace App\DTO;

class IngredientDto
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?float $price,
    )
    {}
}