<?php

namespace Iut\DossiersBundle\Controller;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iut\DossiersBundle\Entity\ModeleMail;

class LoadModeleMailData implements FixtureInterface {

    private $manager;

    public function load(ObjectManager $manager) {
        $this->manager = $manager;

        $modeleMail = [
            ['titre' => "E-Mail vierge", 'message' => ""],
            [
                'titre' => "Prise de contact",
                'message' =>
                    "{{ civilite }} {{ vacataire }},\n
                    Par la présente, je vous demande s'il serait
                    possible de me faire parvenir une photocopie des
                    documents administratifs suivants : {{ pieces }}\n
                    En vous remerciant par avance de l'intérêt que vous
                    porterez à ma demande, je vous prie de croire en
                    l’expression de mes sentiments distingués."
            ],
            [
                'titre' => "Motivation",
                'message' =>
                    "Madame, Monsieur,\n
                    Je me permets de vous contacter pour candidater
                    au poste de responsable de production dans votre
                    usine d’Annecy. Je suis diplômé d’une licence pro
                    industrie agroalimentaire et j’exerce le métier
                    de responsable de production dans une usine de
                    production de conserves depuis 8 ans. A ce poste
                    d’encadrement, je suis responsable de toute la chaîne
                    de production et je manage une équipe d’ouvriers agents
                    de production et de techniciens de maintenance de la chaîne
                    de production de 24 personnes. Après une formation professionnelle
                    de 3 mois en gestion et comptabilité, je souhaite aujourd’hui rejoindre
                    une entreprise leader sur ce marché en tant que responsable de production
                    avec une équipe élargie dans laquelle je pourrai développer mes nouvelles
                    compétences.\nConvaincu de mes capacités et de mon intérêt tout particulier
                    pour votre société, je serais heureux de vous rencontrer afin de vous exposer plus
                    longuement mes motivations. En espérant que ma candidature saura retenir votre attention,
                    je vous adresse, ci-joint, mon CV.\n

                    Je vous prie d’agréer, Madame, Monsieur, l’assurance de ma respectueuse considération."
            ]
        ];

        foreach ($modeleMail as $m)
            $this->newModeleMailEntity($m);

        $this->manager->flush();
    }

    private function newModeleMailEntity($data) {
        $modeleMail = new ModeleMail();
        foreach ($data as $k => $d) {
            $modeleMail->{"set$k"}($d);
        }
        $this->manager->persist($modeleMail);
    }

}
