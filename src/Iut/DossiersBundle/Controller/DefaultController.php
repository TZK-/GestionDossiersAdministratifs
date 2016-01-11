<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Iut\DossiersBundle\Entity\Vacataire;


/**
 * @Route("/dossiers")
 */
class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() {
        $vacataires = $this->getDoctrine()->getManager()->getRepository('IutDossiersBundle:Vacataire');

        return $this->render('IutDossiersBundle:Default:index.html.twig',
                ['vacataires' => $vacataires->findAll()]
        );
    }

}
