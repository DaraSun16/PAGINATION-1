<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create(); // Initialize Faker for creat random data

        // Create 5 Categories
        for ($j = 1; $j <= 5; $j++) {
            $category = new Category();
            $category->setName($faker->word); // Set a random category name
            $category->setSlug($faker->slug); // Set a random slug for the category

            $manager->persist($category); // Persist the category entity

            for ($i = 1; $i <= 300; $i++) { // Loop to create 300 articles
                $articles = new Articles(); // Create a new Articles entity
                $articles->setTitle($faker->sentence(6, true)); // Set a random title
                $articles->setSlug($faker->slug(6, true)); // Set a random slug
                $articles->setAuthor($faker->name); // Set a random author name
                $articles->setPicture($faker->imageUrl('https://picsum.photos/200/300')); // Set a random picture URL
                $articles->setCreatedAt(new \DateTimeImmutable()); // Set the current date and time as created at
                $articles->setCategory($category); // Set the category for the article
                $articles->setPrice($faker->randomFloat(2, 5, 100)); // Set a random price between 10 and 100

                $manager->persist($articles); // Persist the article entity
            }
        }

        $manager->flush(); // Persist all articles to the DB
    }
}
