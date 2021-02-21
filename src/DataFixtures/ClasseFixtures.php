<?php


namespace App\DataFixtures;


use App\Entity\Classe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ClasseFixtures extends Fixture implements FixtureGroupInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $ECE1 = new Classe();
        $ECE1->setNom("ECE1");
        $manager->persist($ECE1);

        $ECE2 = new Classe();
        $ECE2->setNom("ECE2");
        $manager->persist($ECE2);

        $ECS1A = new Classe();
        $ECS1A->setNom("ECS1A");
        $manager->persist($ECS1A);

        $ECS1B = new Classe();
        $ECS1B->setNom("ECS1B");
        $manager->persist($ECS1B);

        $ECS2A = new Classe();
        $ECS2A->setNom("ECS2A");
        $manager->persist($ECS2A);

        $ECS2B = new Classe();
        $ECS2B->setNom("ECS2B");
        $manager->persist($ECS2B);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [

        ];
    }
}