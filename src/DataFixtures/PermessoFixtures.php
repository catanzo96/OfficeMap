<?php

namespace App\DataFixtures;

use App\Entity\Permesso;
use App\Entity\Ruolo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PermessoFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $ruoloAdmin = (fn($obj): Ruolo => $obj)($this->getReference(RuoloFixtures::ROLE_REFERENCE_ADMIN));
        $permessoAdmin = new Permesso();
        $permessoAdmin->setRuolo($ruoloAdmin)
            ->setGestionePrenotazione(true)
            ->setGestioneStanze(true)
            ->setGestioneUtenti(true);
        $manager->persist($permessoAdmin);

        $ruoloCoord = (fn($obj): Ruolo => $obj)($this->getReference(RuoloFixtures::ROLE_REFERENCE_COORDINATORE));
        $permessoCoord = new Permesso();
        $permessoCoord->setRuolo($ruoloCoord)
            ->setGestionePrenotazione(true)
            ->setGestioneStanze(true);
        $manager->persist($permessoCoord);

        $ruoloUser = (fn($obj): Ruolo => $obj)($this->getReference(RuoloFixtures::ROLE_REFERENCE_USER));
        $permessoUser = new Permesso();
        $permessoUser->setRuolo($ruoloUser)
            ->setRichiestaPrenotazione(true);
        $manager->persist($permessoUser);

        $ruoloGuest = (fn($obj): Ruolo => $obj)($this->getReference(RuoloFixtures::ROLE_REFERENCE_GUEST));
        $permessoGuest = new Permesso();
        $permessoGuest->setRuolo($ruoloGuest);
        $manager->persist($permessoGuest);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev', 'typological', 'IDM'];
    }

    public function getDependencies()
    {
        return [RuoloFixtures::class];
    }
}