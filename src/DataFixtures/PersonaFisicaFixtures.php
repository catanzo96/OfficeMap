<?php

namespace App\DataFixtures;

use App\Entity\PersonaFisica;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class PersonaFisicaFixtures extends Fixture implements FixtureGroupInterface
{
    const REFERENCE_DEFAULT = 'persona_fisica_default';
    public function load(ObjectManager $manager)
    {
        $pf = new PersonaFisica();
        $pf->setNome('Giacomo')
            ->setCognome('Catanzaro')
            ->setCf('CTNGCM96H15D862C')
            ->setDataNascita((new DateTime())->setDate('1996', '06', '15'))
            ->setLuogoNascita('Galatina')
            ->setProvinciaNascita('LE');
        $manager->persist($pf);
        $this->addReference(self::REFERENCE_DEFAULT, $pf);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}