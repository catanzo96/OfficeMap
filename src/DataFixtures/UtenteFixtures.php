<?php

namespace App\DataFixtures;

use App\Entity\PersonaFisica;
use App\Entity\PersonaGiuridica;
use App\Entity\Ruolo;
use App\Entity\Utente;
use App\Enum\StatoWorkflow;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtenteFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    const REFERENCE_DEFAULT = 'utente_default';

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $ruolo = (fn($obj): Ruolo => $obj)($this->getReference(RuoloFixtures::ROLE_REFERENCE_ADMIN));
        $pg = (fn($obj): PersonaGiuridica => $obj)($this->getReference(PersonaGiuridicaFixtures::REFERENCE_DEFAULT));
        $pf = (fn($obj): PersonaFisica => $obj)($this->getReference(PersonaFisicaFixtures::REFERENCE_DEFAULT));

        $utente = new Utente();
        $utente->setRuolo($ruolo)
            ->setPersonaFisica($pf)
            ->setPersonaGiuridica($pg)
            ->setTelefono('3275411146')
            ->setEmail('giacomo@example.it')
            ->setPassword(
                $this->encoder->hashPassword($utente, '12345')
            )
            ->setPasswordPrecedente(
                $utente->getPassword()
            )
            ->setStato(StatoWorkflow::ATTIVO->value);
        $manager->persist($utente);
        $this->addReference(self::REFERENCE_DEFAULT, $utente);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PersonaGiuridicaFixtures::class,
            PersonaFisicaFixtures::class,
            RuoloFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }


}