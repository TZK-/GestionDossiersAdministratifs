<?php

namespace Iut\DossiersBundle\Controller;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iut\DossiersBundle\Entity\Vacataire;
use Iut\DossiersBundle\Entity\Formation;

class LoadVacataireData implements FixtureInterface {

    private $manager;

    public function load(ObjectManager $manager) {
        $this->manager = $manager;

        $vacataires = [];

        $noms = [
            'Allison', 'Arthur', 'Ana', 'Alex',
            'Arlene', 'Alberto', 'Barry', 'Bertha',
            'Bill', 'Bonnie', 'Bret', 'Beryl',
            'Chantal', 'Cristobal', 'Claudette', 'Charley',
            'Cindy', 'Chris', 'Dean', 'Dolly'
        ];

        $prenoms = [
            'Abbott', 'Acevedo', 'Acosta', 'Adams',
            'Adkins', 'Aguilar', 'Aguirre', 'Albert',
            'Alexander', 'Alford', 'Allen', 'Allison',
            'Alston', 'Alvarado', 'Alvarez', 'Anderson',
            'Andrews', 'Anthony', 'Armstrong', 'Arnold'
        ];

        $formations = [
            "Informatique",
            "GEA",
            "Réseaux & Télécoms",
            "TC"
        ];

        for ($i = 0; $i < count($noms); $i++) {
            $vacataires[] = [
                'civilite' => (rand(0, 1)) == 0 ? "Monsieur" : "Madame",
                'nom' => $noms[$i],
                'prenom' => $prenoms[$i],
                'mail' => "$prenoms[$i].$noms[$i]@gmail.com",
                'formation' => array_slice($formations, rand(0, count($formations)))
            ];
        }

        foreach ($vacataires as $v)
            $this->newVacataireEntity($v);

        $manager->flush();
    }

    private function newVacataireEntity($data) {
        $vacataire = new Vacataire();

        foreach ($data as $k => $d) {
            if (!is_array($d))
                $vacataire->{"set$k"}($d);
            else {
                switch ($k) {
                    case "formation": {
                            foreach ($d as $f) {
                                $formation = $this->manager->getRepository(Formation::class)->findOneBy(['libelle' => $f]);
                                if (!$formation) {
                                    $formation = new Formation();
                                    $formation->setLibelle($f);
                                    $this->manager->persist($formation);
                                    $this->manager->flush();
                                    $vacataire->addFormation($formation);
                                }
                                $vacataire->addFormation($formation);
                            }
                        }
                }
            }
        }

        $this->manager->persist($vacataire);
    }

}
