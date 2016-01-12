<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {
        $vacataires = $this->getDoctrine()->getManager()->getRepository('IutDossiersBundle:Vacataire');

        return $this->render('IutDossiersBundle:Default:index.html.twig', ['vacataires' => $vacataires->findAll()]
        );
    }

    public function ajouterVacataireAction() {
        

        return $this->render('IutDossiersBundle:Default:ajouterVacataire.html.twig');
    }

}
