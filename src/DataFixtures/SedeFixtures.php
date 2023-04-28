<?php

namespace App\DataFixtures;

use App\Entity\PersonaGiuridica;
use App\Entity\Sede;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SedeFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    const REFERENCE_DEFAULT = 'sede_default';
    public function load(ObjectManager $manager)
    {
        $pg = (fn($obj): PersonaGiuridica => $obj)($this->getReference(PersonaGiuridicaFixtures::REFERENCE_DEFAULT));
        $sede = new Sede();
        $sede->setPersonaGiuridica($pg)
            ->setPaese('Italia')
            ->setCitta('Roma')
            ->setProvincia('RM')
            ->setCap('00161')
            ->setVia('Via Giovanni Battista Morgagni')
            ->setCivico('30E, Palazzo C, 5° Piano')
            ->setIsLegale(false)
            ->setIsOperativa(true);
        $manager->persist($sede);
        $this->addReference(self::REFERENCE_DEFAULT, $sede);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [PersonaGiuridicaFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}