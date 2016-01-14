<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Iut\DossiersBundle\Entity\MailRelance;
use Iut\DossiersBundle\Form\MailRelanceType;
use Iut\DossiersBundle\Entity\ModeleMail;
use \Iut\DossiersBundle\Form\ModeleMailType;

class MailController extends Controller {

    public function envoyerMailAction(Request $request, $dossierId) {

        /* @TODO
         * Récupérer le dossier dans la BDD
         * Charger le mail suivant les infos du dossier
         * Envoyer le mail
         */

        $entityManager = $this->getDoctrine()->getManager()->getRepository(MailRelance::class);
        $dossier = $entityManager->find($dossierId);

//        if(!$dossier){
//            $this->addFlash('warning', "Le dossier numéro $dossierId n'existe pas !");
//            return $this->redirectToRoute('homepage');
//        }

        $modelesMail = $this->getDoctrine()->getManager()->getRepository(ModeleMail::class);
        $formModeles = $this->createForm(ModeleMailType::class);

        return $this->render("IutDossiersBundle:Mail:envoyerMailRelance.html.twig", [
            'title' => "Relancer le dossier",
            'form' => $formModeles->createView(),
        ]);
    }

}
