<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Schema\Index;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;


class NewsFixtures extends Fixture
{
    private array $titles = [
        'Nouveau cours Unity',
        'Game Jam KapabForge',
        'Godot 4 : nouveautés',
        'Le pixel art débarque',
        'Masterclass Unreal',
        'Résultats du concours',
        'Sound design 101',
        'Atelier game design',
        'Soirée e-sport',
        'Nouvelle plateforme',
    ];
    public function __construct(private readonly SluggerInterface $slugger)
    {

    }
    public function load(ObjectManager $manager): void
    {
         // Instanciation de phpFaker
        $faker = Factory::create('fr_FR');

        foreach($this->titles as $index => $titles) {
            $news = new News()
                ->setName($titles)
                ->setContent($faker->paragraphs(rand(10, 20), true))
                ->setImage(($index + 1) . '.jpg')
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', '-1 month')))
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 month', 'now')))
                ->setIsPublished($faker->boolean(80));
            $news->setSlug($this->slugger->slug($news->getName())->lower());
            $manager->persist($news);
        }
        $manager->flush();
    }
}
