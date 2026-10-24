<?php

namespace App\DataFixtures;

use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LevelFixtures extends Fixture
{
    private array $levels = [
        'Débutant' => 'Aucune connaissance n\'est nécessaire. Idéal pour découvrir la création de jeux vidéo.',
        'Intermédiaire' => 'Avoir déjà pris en main un moteur de jeu (Unity, Godot ou Unreal) et connaître les bases de la programmation : variables, conditions, boucles.',
        'Avancé' => 'Maîtriser un moteur de jeu et un langage de script (C#, GDScript ou C++), et avoir déjà réalisé au moins un petit projet de jeu complet.',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->levels as $name => $prerequisite) {
            $level = new Level();
            $level->setName($name);
            $level->setPrerequisites($prerequisite);
            $manager->persist($level);
        }
        $manager->flush();
    }
}
