<?php

namespace App\Mapper;

use App\DTO\RecipeDto;
use App\Entity\Recipe;

class RecipeMapper
{
    public function recipeToDto(Recipe $recipe): RecipeDto
    {
        return new RecipeDto(
    id: $recipe->getId(),
    name: $recipe->getName(),
    time: $recipe->getTime(),
    nbPeople: $recipe->getNbPeople(),
    difficulty: $recipe->getDifficulty(),
    description: $recipe->getDescription(),
    price: $recipe->getPrice(),
    isFavorite: $recipe->isFavorite(),
);
    }
}