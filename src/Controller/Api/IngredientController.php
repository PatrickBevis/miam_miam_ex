<?php

namespace App\Controller\Api;

use App\Entity\Ingredient;
use App\Mapper\IngredientMapper;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/ingredients')]
class IngredientController extends AbstractController{

    #[Route('', name: 'api_ingredient_index', methods:['GET'])]
    public function index(
        IngredientRepository $ingredientRepository,
        IngredientMapper $ingredientMapper
    ): JsonResponse

    {
    $ingredients = $ingredientRepository->findAll();
    $data = array_map(
        fn(ingredient $item) =>$ingredientMapper->ingredientToDto($item), $ingredients
    );
    return $this->json($data);
}
    #[Route('/{id}', name: 'ingredient', methods:['GET'])]
    public function show(
        Ingredient $ingredient, 
        IngredientMapper $ingredientMapper
        ): JsonResponse 
        
        {
            $data =$ingredientMapper->ingredientToDto($ingredient);
            return $this->json($data);    
    }
}
