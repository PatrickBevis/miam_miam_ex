<?php

namespace App\Mapper;

use App\DTO\IngredientDto;
use App\Entity\Ingredient;


class IngredientMapper
{
    public function ingredientToDto(Ingredient $ingredient): IngredientDto
    {
        return new IngredientDto(
    id: $ingredient->getId(),
    name: $ingredient->getName(),
    price: $ingredient->getPrice(),
);
    }
}