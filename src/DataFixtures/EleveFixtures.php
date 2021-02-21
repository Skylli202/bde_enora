<?php


namespace App\DataFixtures;


use App\Entity\Classe;
use App\Entity\Eleve;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class EleveFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        if (($handle = fopen(__DIR__.'/classes_utf8.csv', 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                $lastname = $data[0];
                $firstname = $data[1];
                $class = $data[2];

//                dump($lastname . " " . $firstname . " " . $class);

                $classe = $manager->getRepository(Classe::class)->findOneBy(['nom' => $class]);
                if (!is_null($classe)) {
                    $eleve = new Eleve();
                    $eleve->setNom($lastname)->setPrenom($firstname);
                    $classe->addEleve($eleve);
                    $manager->persist($eleve);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return[
            ClasseFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return [

        ];
    }
}