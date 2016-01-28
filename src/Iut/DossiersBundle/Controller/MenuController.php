<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller {

    public function genererMenuAction($parentPath) {
        $menu = [
            ['route' => 'homepage', 'icon' => "fa fa-link", 'label' => "Accueil"],
            ['route' => 'afficherListeVacataires', 'icon' => "fa fa-link", 'label' => "Vacataires",
                'children' => [
                    ['route' => 'ajouterVacataire', 'label' => "Ajouter"]
                ]
            ],
            ['route' => 'homepage', 'icon' => "fa fa-link", 'label' => "Pièces",
                'children' => [
                    ['route' => 'ajouterPiece', 'label' => "Ajouter"]
                ]
            ],
            ['route' => 'afficherListeModelesMail', 'icon' => "fa fa-link", 'label' => "Modèles mail",
                'children' => [
                    ['route' => 'ajouterModeleMail', 'label' => "Ajouter"]
                ]
            ],
            ['route' => 'homepage', 'icon' => "fa fa-link", 'label' => "Formations",
                'children' => [
                    ['route' => 'ajouterFormation', 'label' => "Ajouter"]
                ]
            ],
            ['route' => 'creerDossier', 'icon' => "fa fa-link", 'label' => "Créer dossier"],
        ];

        return $this->render('IutDossiersBundle:Menu:menu.html.twig', [
                    'menu' => $menu,
                    'parentPath' => $parentPath
        ]);
    }

}
