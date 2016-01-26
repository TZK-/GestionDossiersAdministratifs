<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller {

    public function genererMenuAction($route) {
        $menu = [
            ['route' => 'homepage', 'icon' => "fa fa-link", 'label' => "Accueil"],
            ['route' => 'afficherListeVacataires', 'icon' => "fa fa-link", 'label' => "Liste vacataires"],
            ['route' => 'ajouterVacataire', 'icon' => "fa fa-link", 'label' => "Ajouter vacataires"],
            ['route' => 'ajouterPiece', 'icon' => "fa fa-link", 'label' => "Ajouter Pièce"],
            ['route' => 'afficherListeModelesMail', 'icon' => "fa fa-link", 'label' => "Afficher les modèles"],
            ['route' => 'ajouterModeleMail', 'icon' => "fa fa-link", 'label' => "Ajouter un modèle"],
            ['route' => 'creerDossier', 'icon' => "fa fa-link", 'label' => "Creer dossier"],
        ];

        return $this->render('IutDossiersBundle:Menu:base.menu.html.twig', [
                    'menu' => $menu,
                    'parentRoute' => $route
        ]);
    }

}
