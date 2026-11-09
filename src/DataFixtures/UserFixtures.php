<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private array $genders = ['male', 'female', 'other', null];
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {

    }
    public function load(ObjectManager $manager): void
    {
        $faker =Factory::create('fr_FR');


        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $gender = $faker->randomElement($this->genders);
            $user->setFirstName($faker->firstName(in_array($gender, ['male', 'female']) ? $gender : null));
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->unique()->email());
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $user->setRoles(['ROLE_USER']);
            $user->setImage(null);
            $user->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', '-1 month')));
            $user->setIsDisabled($faker->boolean(20));
            $manager->persist($user);
        }
        $manager->flush();

        $admin1 = new User();
        $admin1->setFirstName('Florent');
        $admin1->setLastName('Techer');
        $admin1->setGender('male');
        $admin1->setEmail('admin@example.com');
        $admin1->setPassword($this->passwordHasher->hashPassword($admin1, 'password'));
        $admin1->setRoles(['ROLE_ADMIN']);
        $admin1->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', '-1 month')));
        $admin1->setIsDisabled(false);
        $manager->persist($admin1);
        
        $admin2 = new User();
        $admin2->setFirstName('John');
        $admin2->setLastName('Doe');
        $admin2->setGender('male');
        $admin2->setEmail('admin2@example.com');
        $admin2->setPassword($this->passwordHasher->hashPassword($admin2, 'password'));
        $admin2->setRoles(['ROLE_SUPER_ADMIN']);
        $admin2->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', '-1 month')));
        $admin2->setIsDisabled(false);
        $manager->persist($admin2);
        $manager->flush();
    }
}
