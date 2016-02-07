<?php

namespace Iut\DossiersBundle\Controller;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iut\DossiersBundle\Entity\Etat;

class LoadEtatData implements FixtureInterface {

    private $manager;

    public function load(ObjectManager $manager) {
        $this->manager = $manager;

        $etats = [
            "Incomplet",
            "Complet",
        ];

        foreach ($etats as $e)
            $this->newPieceEntity($e);
        $this->manager->flush();
    }

    private function newPieceEntity($data) {
        $etat = new Etat();
        $etat->setLibelle($data);
        $this->manager->persist($etat);
    }

}
