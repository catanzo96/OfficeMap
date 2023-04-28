<?php

namespace App\DataFixtures;

use App\Entity\Postazione;
use App\Entity\Stanza;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostazioneFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    const REFERENCE_DEFAULT = 'postazione_default';
    public function load(ObjectManager $manager)
    {
        $stanza = (fn($obj): Stanza => $obj)($this->getReference(StanzaFixtures::REFERENCE_DEFAULT));
        $postazione = new Postazione();
        $postazione->setStanza($stanza)
            ->setHasMonitor(true)
            ->setHasTastiera(true)
            ->setHasMouse(false);
        $manager->persist($postazione);
        $this->addReference(self::REFERENCE_DEFAULT, $postazione);

        $manager->flush();

    }
    public function getDependencies(): array
    {
        return [StanzaFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }

}