<?php

namespace App\DataFixtures;

use App\Entity\Sede;
use App\Entity\Stanza;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StanzaFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    const REFERENCE_DEFAULT = 'stanza_default';
    public function load(ObjectManager $manager)
    {
        $sede = (fn($obj): Sede => $obj)($this->getReference(SedeFixtures::REFERENCE_DEFAULT));
        $stanza = new Stanza();
        $stanza->setSede($sede)
            ->setPiano('5')
            ->setNome('Sala Principale');
        $manager->persist($stanza);
        $this->addReference(self::REFERENCE_DEFAULT, $stanza);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SedeFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }

}