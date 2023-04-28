<?php

namespace App\DataFixtures;

use App\Entity\Ruolo;
use App\Enum\StatoWorkflow;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class RuoloFixtures extends Fixture implements FixtureGroupInterface
{
    const ROLE_REFERENCE_ADMIN = 'ruolo_admin';
    const ROLE_REFERENCE_COORDINATORE = 'ruolo_coordinatore';
    const ROLE_REFERENCE_USER = 'ruolo_user';
    const ROLE_REFERENCE_GUEST = 'ruolo_guest';
    public function load(ObjectManager $manager): void
    {
        $ruoloAdmin = new Ruolo();
        $ruoloAdmin->setDescrizione('Amministratore')
                ->setCodice('ROLE_ADMIN')
                ->setStato(StatoWorkflow::ATTIVO->value)
                ->setDefaultRoute('app_frontend_dashboard');
        $manager->persist($ruoloAdmin);
        $this->addReference(self::ROLE_REFERENCE_ADMIN, $ruoloAdmin);

        $ruoloCoordinatore = new Ruolo();
        $ruoloCoordinatore->setDescrizione('Coordinatore')
            ->setCodice('ROLE_COORD')
            ->setStato(StatoWorkflow::ATTIVO->value)
            ->setDefaultRoute('app_frontend_dashboard');
        $manager->persist($ruoloCoordinatore);
        $this->addReference(self::ROLE_REFERENCE_COORDINATORE, $ruoloCoordinatore);

        $ruoloUser = new Ruolo();
        $ruoloUser->setDescrizione('User')
            ->setCodice('ROLE_USER')
            ->setStato(StatoWorkflow::ATTIVO->value)
            ->setDefaultRoute('app_frontend_dashboard');
        $manager->persist($ruoloUser);
        $this->addReference(self::ROLE_REFERENCE_USER, $ruoloUser);

        $ruoloGuest = new Ruolo();
        $ruoloGuest->setDescrizione('Guest')
            ->setCodice('ROLE_GUEST')
            ->setStato(StatoWorkflow::ATTIVO->value)
            ->setDefaultRoute('app_frontend_altro');
        $manager->persist($ruoloGuest);
        $this->addReference(self::ROLE_REFERENCE_GUEST, $ruoloGuest);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}