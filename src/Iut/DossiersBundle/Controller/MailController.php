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

        // if(!$dossier){
        //    $this->addFlash('warning', "Le dossier numéro $dossierId n'existe pas !");
        //    return $this->redirectToRoute('homepage');
        // }

        $modelesMail = $this->getDoctrine()->getManager()->getRepository(ModeleMail::class);
        $formModeles = $this->createForm(ModeleMailType::class);

        return $this->render("IutDossiersBundle:Mail:envoyerMailRelance.html.twig", [
                    'title' => "Relancer le dossier",
                    'form' => $formModeles->createView(),
        ]);
    }

    public function ajouterModeleMailAction(Request $request) {

        $mail = new ModeleMail();

        $form = $this->createForm(ModeleMailType::class, $mail);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $entytymanager = $this->getDoctrine()->getManagerForClass(ModeleMail::class);
            $entytymanager->persist($mail);
            $entytymanager->flush();
            $this->addFlash('success', 'Le modèle de mail a bien été ajouté');
            return $this->redirectToRoute('afficherListeModelesMail');
        }

        return $this->render('IutDossiersBundle:Mail:ajouterModeleMail.html.twig', [
                    'title' => "Ajouter un modèle de mail",
                    'form' => $form->createView()
        ]);
    }

    public function listeModelesMailAction() {
        $mails = $this->getDoctrine()->getManager()->getRepository('IutDossiersBundle:ModeleMail');

        return $this->render('IutDossiersBundle:Mail:listeModelesMail.html.twig', [
                    'mails' => $mails->findBy([], ['id' => 'ASC'])]
        );
    }

    public function afficherModeleMailAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $mails = $entityManager->getRepository(ModeleMail::class);

        $mail = $mails->find($id);

        if (!$mail) {
            $this->addFlash('danger', "Le mail n'existe pas !");
            return $this->redirectToRoute('consulterModeleMail');
        }

        return $this->render('IutDossiersBundle:Mail:afficherModeleMail.html.twig', [
                    'mail' => $mail
        ]);
    }

    public function supprimerModeleMailAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $mails = $entityManager->getRepository(ModeleMail::class);

        $mail = $mails->find($id);

        if (!$mail) {
            $this->addFlash('danger', "Le mail n'existe pas !");
        } else {
            $entityManager->remove($mail);
            $entityManager->flush();
            $this->addFlash('success', "Le mail a bien été supprimé !");
        }

        return $this->redirectToRoute('consulterModeleMail');
    }

}
