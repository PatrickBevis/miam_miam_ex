<?php

namespace App\Controller\Api;

use App\Entity\Recipe;
use App\Mapper\RecipeMapper;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/recipes')]
class RecipeController extends AbstractController{

    #[Route('', name: 'api_recipe_index', methods:['GET'])]
    public function index(
        RecipeRepository $recipeRepository,
        RecipeMapper $recipeMapper
    ): JsonResponse

    {
    $recipes = $recipeRepository->findAll();
    $data = array_map(
        fn(Recipe $item) =>$recipeMapper->recipeToDto($item), $recipes
    );
    return $this->json($data);
}
    #[Route('/{id}', name: 'recipe', methods:['GET'])]
    public function show(
        Recipe $recipe, 
        RecipeMapper $recipeMapper
        ): JsonResponse 
        
        {
            $data =$recipeMapper->recipeToDto($recipe);
            return $this->json($data);    
    }
}