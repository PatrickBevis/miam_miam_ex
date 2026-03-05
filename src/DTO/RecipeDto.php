<?php

namespace App\DTO;

class RecipeDto
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?int $time,
        public ?int $nbPeople,
        public ?int $difficulty,
        public ?string $description,
        public ?int $price,
        public ?bool $isFavorite,
         
    )
    {}

}