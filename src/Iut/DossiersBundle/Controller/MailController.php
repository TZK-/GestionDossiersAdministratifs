<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Iut\DossiersBundle\Entity\ModeleMail;
use Iut\DossiersBundle\Form\ModeleMailType;
use Iut\DossiersBundle\Entity\MailRelance;
use Iut\DossiersBundle\Form\MailRelanceType;
use Iut\DossiersBundle\Form\ModeleMailListeType;
use Iut\DossiersBundle\Entity\Dossier;

class MailController extends Controller {

    public function envoyerRelanceAction(Request $request, $dossierId) {

        $modeleMail = new ModeleMail();
        $mailRelance = new MailRelance();

        $formModeleMail = $this->createForm(ModeleMailListeType::class, $modeleMail);

        $formMailRelance = $this->createForm(MailRelanceType::class, $mailRelance);

        $formModeleMail->handleRequest($request);
        $formMailRelance->handleRequest($request);

        if ($formModeleMail->isSubmitted() && $formModeleMail->isValid()) {

            $mailRelance->setTitre($modeleMail->getTitre()->getTitre());
            $mailRelance->setMessage($modeleMail->getTitre()->getMessage());

            $formMailRelance = $this->createForm(MailRelanceType::class, $mailRelance);

            return $this->render("IutDossiersBundle:Mail/Envoi:relance_envoyer.html.twig", [
                        'title' => "Relancer le dossier",
                        'form' => $formMailRelance->createView(),
            ]);
        }

        if ($formMailRelance->isSubmitted() && $formMailRelance->isValid()) {

            /* Envoi du mail */
            $message = \Swift_Message::newInstance()
                    ->setSubject($mailRelance->getTitre())
                    ->setFrom('sender@mail.com')
                    ->setTo('receiver@mail.com')
                    ->setBody(
                    $this->renderView(
                            'IutDossiersBundle:Mail/Envoi:base.relance.html.twig', ['message' => $mailRelance->getMessage()]
                    ), 'text/html'
                    )
            ;

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('homepage');
        }

        return $this->render("IutDossiersBundle:Mail/Envoi:relance_envoyer.html.twig", [
                    'title' => "Relancer le dossier",
                    'form' => $formModeleMail->createView(),
        ]);
    }

    /**
     * Parse le mail de relance afin d'ajouter les elements dynamiques tel que le Nom/Prénom et les pièces manquantes
     * @param MailRelance $mail
     * @param type $dossierId
     */
    private function parseMailRelance(MailRelance $mail, $dossierId) {
        $dossier = $this->getDoctrine()->getManager()->getRepository(Dossier::class)->find($dossierId);
        $args = [
            'pieces' => $dossier->getPieces()->toArray(),
            'vacataire' => $dossier->getVacataire()
        ];
    }

    public function ajouterModeleMailAction(Request $request, $id) {

        if ($id == -1) {
            $mail = new ModeleMail();
        } else {
            $mail = $this->getDoctrine()->getManager()->getRepository(ModeleMail::class)->find($id);

            if (!$mail) {
                $this->addFlash('warning', "Le modèle de mail n'existe pas.");
                return $this->redirectToRoute('modele-mail_liste');
            }
        }

        $form = $this->createForm(ModeleMailType::class, $mail);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            $this->getDoctrine()->getManager()->persist($mail);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le modèle de mail a bien été ajouté');
            return $this->redirectToRoute('modele-mail_liste');
        }

        return $this->render('IutDossiersBundle:Mail/Modele:modele_ajouter.html.twig', [
                    'title' => "Ajouter un modèle de mail",
                    'form' => $form->createView()
        ]);
    }

    public function listeModelesMailAction() {
        $mails = $this->getDoctrine()->getManager()->getRepository('IutDossiersBundle:ModeleMail');

        return $this->render('IutDossiersBundle:Mail/Modele:modele_liste.html.twig', [
                    'title' => "Modèle de mails",
                    'mails' => $mails->findBy([], ['id' => 'ASC'])]
                    
        );
    }

    public function afficherModeleMailAction($id) {
        $mail = $this->getDoctrine()->getManager()->getRepository(ModeleMail::class)->find($id);

        if (!$mail) {
            $this->addFlash('warning', "Le modèle de mail n'existe pas !");
            return $this->redirectToRoute('modele-mail_liste');
        }

        return $this->render('IutDossiersBundle:Mail/Modele:modele_afficher.html.twig', [
                    'mail' => $mail
        ]);
    }

    public function supprimerModeleMailAction($id) {
        $mail = $this->getDoctrine()->getManager()->getRepository(ModeleMail::class)->find($id);

        if (!$mail) {
            $this->addFlash('warning', "Le modèle de mail n'existe pas !");
        } else {
            $this->getDoctrine()->getManager()->remove($mail);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', "Le modèle de mail a bien été supprimé !");
        }

        return $this->redirectToRoute('modele-mail_liste');
    }

}
