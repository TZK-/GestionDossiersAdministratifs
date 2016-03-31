<?php

namespace Iut\DossiersBundle\Controller;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iut\DossiersBundle\Entity\Piece;

class LoadPieceData implements FixtureInterface {

    private $manager;

    public function load(ObjectManager $manager) {
        $this->manager = $manager;

        $pieces = [
            "Pièce d’identité",
            "Photos d’identité",
            "Acte de naissance",
            "Justificatifs de domicile",
        ];

        foreach ($pieces as $p)
            $this->newPieceEntity($p);
        $this->manager->flush();
    }

    private function newPieceEntity($data) {
        $piece = new Piece();
        $piece->setLibelle($data);
        $this->manager->persist($piece);
    }

}
