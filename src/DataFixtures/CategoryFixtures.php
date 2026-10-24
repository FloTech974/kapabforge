<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private array $categories = ['Game design','Programmation de jeux vidéo','Unity','Godot','Unreal Engine','Sound Design','2D / Pixel Art','Modélisation 3D','E-Sport et Streaming'];
    public function __construct(private readonly SluggerInterface $slugger)
    {

    }
    public function load(ObjectManager $manager): void
    {
        // Créer et persiter les catégories
        foreach ($this->categories as $category) {
            $cat = new Category();
            $cat->setName($category);
            $cat->setSlug($this->slugger->slug($category)->lower());
            $manager->persist($cat);
        }

        $manager->flush();
    }
}
