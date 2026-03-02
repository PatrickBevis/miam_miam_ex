<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ingredient=[];
        for($i=1; $i <50; $i++){
        $ingredient = new Ingredient();
        $ingredient->setName("Ingredient $i")
                   ->setPrice(mt_rand(0,100));
        $ingredients[] = $ingredient;
        $manager->persist($ingredient);
        }

        for($j=1; $j <25; $j++){
        $recipe = new Recipe();
        $recipe->setName("Ingredient $j")
               ->setTime(mt_rand(1,1440))
               ->setNbPeople(mt_rand(1,50))
               ->setDifficulty(mt_rand(1,5))
               ->setDescription("Desc $j")
               ->setPrice(mt_rand(1,100))
               ->setIsFavorite((bool)mt_rand(0,1));

               for($k=1; $k <50; $k++){
                $recipe->addIngredient($ingredients[mt_rand(0,count($ingredients)-1)]);
               }
        $manager->persist($recipe);
        }
        $manager->flush();
    }
}
