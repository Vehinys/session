<?php

namespace App\DataFixtures;


use Faker\Factory;
use Faker\Generator;
use App\Entity\Session;
use App\Entity\Trainee;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    private Generator $faker;
    
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    // Stagiaires
    public function load(ObjectManager $manager): void
    {
            $trainees =  [];
            for ($i=0; $i < 10 ; $i++) { 
                $trainee = new Trainee();
                $trainee->setName(($this->faker->lastName()))
                    ->setFirstName(($this->faker->firstName()))
                    ->setSex('Homme') 
                    ->setDateBirth(new \DateTimeImmutable($this->faker->dateTimeBetween('-40 years', '-18 years')->format('Y-m-d'))) 
                    ->setTown($this->faker->city())
                    ->setEmail($this->faker->email())
                    ->setTelephone($this->faker->phoneNumber());

                $trainees[] = $trainee;

                $manager->persist($trainee);
            }

            // Sessions
            for ($j = 0; $j < 15 ; $j++) {
                $session = new Session();
                $session->setName($this->faker->word())
                    ->setStartSession(new \DateTimeImmutable($this->faker->dateTimeBetween('-3 months', '-1 days')->format('Y-m-d')))
                    ->setEndSession(new \DateTimeImmutable($this->faker->dateTimeBetween('+3 months', '+6 months')->format('Y-m-d')))
                    ->setNbPlaces(rand(6, 10))
                    ->setNbPlacesReserved(rand(1, 5));

            for ($k = 0; $k < mt_rand(1,5); $k++) {
                $session->addTrainee($trainees[mt_rand(0, count($trainees) - 1)]);
            }

            $manager->persist($session);
         }

        $manager->flush();
    }
}