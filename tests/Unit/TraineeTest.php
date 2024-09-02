<?php

namespace App\Tests\Unit;

use App\Entity\Trainee;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TraineeTest extends KernelTestCase
{
    public function getEntity() : Trainee
    {
        return (new Trainee())
            ->setName('test')
            ->setFirstName('test')
            ->setSex('test')
            ->setDateBirth(new \DateTimeImmutable())
            ->setTown('test')
            ->setEmail('test')
            ->setTelephone('test');
    }

    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $trainee = new Trainee();
        $trainee = $this->getEntity();

        $errors = $container->get('validator')->validate($trainee);

        $this->assertCount(0, $errors);

    }

    public function testInvalidName()
    {

        self::bootKernel();
        $container = static::getContainer();
        
        $trainee = $this->getEntity();
        $trainee->setName('');
    
        $errors = $container->get('validator')->validate($trainee);
        $this->assertCount(0, $errors);
        
    }

}
