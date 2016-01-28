<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller {

    public function genererMenuAction($parentPath) {
        $menu = [
            ['label' => "Accueil", 'route' => 'homepage', 'icon' => "fa fa-home"],
            ['label' => "Créer dossier", 'route' => 'creerDossier', 'icon' => "fa fa-folder"],
            ['label' => "Vacataires", 'icon' => "fa fa-users", 'children' => [
                    ['label' => "Afficher vacataires", 'route' => 'afficherListeVacataires'],
                    ['label' => "Ajouter", 'route' => 'ajouterVacataire']
                ]
            ],
            ['label' => "Pièces", 'icon' => "fa fa-paperclip", 'children' => [
                    ['label' => "Afficher pièces", 'route' => 'ajouterPiece'], // TODO Update
                    ['label' => "Ajouter", 'route' => 'ajouterPiece']
                ]
            ],
            ['label' => "Formations", 'icon' => "fa fa-graduation-cap", 'children' => [
                    [ 'label' => "Liste formations", 'route' => 'ajouterFormation'], // TODO Update
                    [ 'label' => "Ajouter", 'route' => 'ajouterFormation']
                ]
            ],
            ['label' => "Modèles mail", 'icon' => "fa fa-envelope", 'children' => [
                    [ 'label' => "Liste modèles", 'route' => 'afficherListeModelesMail'], // TODO Update
                    [ 'label' => "Ajouter", 'route' => 'ajouterModeleMail']
                ]
            ]
        ];

        return $this->render('IutDossiersBundle:Menu:menu.html.twig', [
                    'menu' => $menu,
                    'parentPath' => $parentPath
        ]);
    }

}
