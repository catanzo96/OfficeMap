<?php

namespace App\DataFixtures;

use App\Entity\PersonaGiuridica;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class PersonaGiuridicaFixtures extends Fixture implements FixtureGroupInterface
{
    const REFERENCE_DEFAULT = 'persona_giuridica_default';
    public function load(ObjectManager $manager)
    {
        $personaGiuridica = new PersonaGiuridica();
        $personaGiuridica->setRagioneSociale('Links Management and Technology')
            ->setPIva(' 03351210756')
            ->setClassificazione('Società di capitali');
        $manager->persist($personaGiuridica);
        $this->addReference(self::REFERENCE_DEFAULT, $personaGiuridica);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }

}