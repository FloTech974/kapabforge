<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Category;
use App\Entity\Level;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly SluggerInterface $slugger)
    {

    }
    public function load(ObjectManager $manager): void
    {
        // Instanciation de phpFaker
        $faker = Factory::create('fr_FR');
        // Récupère les catégories
        $categories = $manager->getRepository(Category::class)->findAll();
        // Récupère les niveaux
        $levels = $manager->getRepository(Level::class)->findAll();
        // Créer et persister les cours
        for ($i = 1; $i <= 10; $i++) {
            $course = new Course()
                ->setName($faker->words(rand(2,4), true))
                ->setShortDescription($faker->sentence(rand(10, 20)))
                ->setDescription($faker->paragraphs(rand(3, 7), true))
                ->setPrice($faker->randomFloat(2, 0, 100))
                ->setDuration($faker->numberBetween(1, 20))
                ->setLessonCount($faker->numberBetween(1, 50))
                ->setSoftware($faker->randomElement(['Unity', 'Godot', 'Unreal Engine'])) 
                // ->setImage($i . '.jpg')
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', '-1 month')))
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 month', 'now')))
                ->setIsPublished($faker->boolean(80))
                ->setCategory($faker->randomElement($categories))
                ->setLevel($faker->randomElement($levels));
            $course->setSlug($this->slugger->slug($course->getName())->lower());    
            $manager->persist($course);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            LevelFixtures::class,
        ];
    }
}
