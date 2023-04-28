<?php

namespace App\DataFixtures;

use App\Entity\Postazione;
use App\Entity\Prenotazione;
use App\Entity\Utente;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PrenotazioneFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $utente = (fn($obj): Utente => $obj)($this->getReference(UtenteFixtures::REFERENCE_DEFAULT));
        $postazione = (fn($obj): Postazione => $obj)($this->getReference(PostazioneFixtures::REFERENCE_DEFAULT));

        $prenotazione = new Prenotazione();
        $prenotazione->setUtente($utente)
            ->setPostazione($postazione)
            ->setDataPrenotazione((new DateTime())->setDate('2023', '04', '18'))
            ->setStato(2);

        $manager->persist($prenotazione);
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UtenteFixtures::class,
            PostazioneFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }

}