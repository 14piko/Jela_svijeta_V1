<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Food;
use App\Entity\Ingredients;
use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $faker->addProvider(new \App\Faker\FakerFood($faker));

        for($i = 0;$i<10;$i++){
            $category = new Category();
            $category->setTitle($faker->kategorijaJela());
            $manager->persist($category);

            $tags = new Tags();
            $tags->setTitle($faker->oznakaHrane());
            $manager->persist($tags);

            $ingredients = new Ingredients();
            $ingredients->setTitle($faker->imeSastojka());
            $manager->persist($ingredients);

            $food = new Food();
            $food->setName($faker->imeHrane());
            $food->setCategory($category);
            $food->setIngredients($ingredients);
            $food->setTags($tags);
            $manager->persist($food);
        }

        for($i = 0;$i<5;$i++)
        {
            $ingredients = new Ingredients();
            $ingredients->setTitle($faker->imeSastojka());
            $manager->persist($ingredients);

            $tags = new Tags();
            $tags->setTitle($faker->oznakaHrane());
            $manager->persist($tags);

            $food = new Food();
            $food->setName($faker->imeHrane());
            $food->setCategory(null);
            $food->setIngredients($ingredients);
            $food->setTags($tags);
            $manager->persist($food);
        }

        $manager->flush();
    }
}
