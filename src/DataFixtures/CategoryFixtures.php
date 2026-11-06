<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private array $categories = [
        'Game design'                 => 'Imaginez des règles, des niveaux et des mécaniques qui rendent un jeu captivant.',
        'Programmation de jeux vidéo' => 'Apprenez à coder la logique de vos jeux : déplacements, collisions, intelligence artificielle.',
        'Unity'                       => 'Le moteur le plus utilisé du jeu indépendant, pour créer en 2D comme en 3D avec C#.',
        'Godot'                       => 'Un moteur libre, gratuit et léger, idéal pour débuter en 2D avec GDScript.',
        'Unreal Engine'               => 'Le moteur des productions AAA, pour des jeux 3D aux graphismes spectaculaires.',
        'Sound Design'                => 'Créez musiques, bruitages et ambiances sonores qui donnent vie à vos jeux.',
        '2D / Pixel Art'              => 'Dessinez et animez personnages, décors et objets en pixel art.',
        'Modélisation 3D'             => 'Modélisez, texturez et animez des personnages et des environnements en 3D.',
        'E-Sport et Streaming'        => 'Découvrez la compétition, le cast et la diffusion de vos parties en direct.',
    ];
    public function __construct(private readonly SluggerInterface $slugger)
    {

    }
    public function load(ObjectManager $manager): void
    {
        foreach ($this->categories as $name => $description) {
            $slug = $this->slugger->slug($name)->lower();

            $cat = new Category();
            $cat->setName($name);
            $cat->setSlug($slug);
            $cat->setDescription($description);
            $cat->setImage($slug . '.jpg');
            $manager->persist($cat);
        }
        $manager->flush();
    }
}
