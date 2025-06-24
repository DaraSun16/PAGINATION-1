<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create(); // Initialize Faker for creat random data

        for ($i = 1; $i <= 300; $i++) { // Loop to create 300 articles
            $articles = new Articles(); // Create a new Articles entity
            $articles->setTitle($faker->sentence(6, true)); // Set a random title
            $articles->setSlug($faker->slug(6, true)); // Set a random slug
            $articles->setAuthor($faker->name); // Set a random author name
            $articles->setPicture($faker->imageUrl(640, 480, 'abstract', true)); // Set a random picture URL
            $articles->setCreatedAt(new \DateTimeImmutable()); // Set the current date and time as created at

            $manager->persist($articles); // Persist the article entity
        }

        $manager->flush(); // Persist all articles to the DB
    }
}
