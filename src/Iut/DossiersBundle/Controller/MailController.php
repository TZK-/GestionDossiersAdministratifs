<?php

namespace Iut\DossiersBundle\Controller;

use Iut\DossiersBundle\Entity\Dossier;
use Iut\DossiersBundle\Entity\MailRelance;
use Iut\DossiersBundle\Entity\ModeleMail;
use Iut\DossiersBundle\Form\MailRelanceType;
use Iut\DossiersBundle\Form\ModeleMailListeType;
use Iut\DossiersBundle\Form\ModeleMailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MailController extends Controller {

    public function envoyerRelanceAction(Request $request, $dossierId) {

        $modeleMail = new ModeleMail();
        $mailRelance = new MailRelance();

        $formModeleMail = $this->createForm(ModeleMailListeType::class, $modeleMail);

        $formMailRelance = $this->createForm(MailRelanceType::class, $mailRelance);

        $formModeleMail->handleRequest($request);
        $formMailRelance->handleRequest($request);

        $dossier = $this->getDoctrine()->getRepository(Dossier::class)->find($dossierId);
        $vacataire = $dossier->getVacataire();

        if ($formModeleMail->isSubmitted() && $formModeleMail->isValid()) {

            $mailRelance->setTitre($modeleMail->getTitre()->getTitre());
            $mailRelance->setMessage($modeleMail->getTitre()->getMessage());

            $mailRelance = $this->parseMail($mailRelance, $dossier);

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
                ->setFrom('marion.berthoz@iut-valence.fr')
                ->setTo($vacataire->getMail())
                ->setBody(
                    $this->renderView(
                        'IutDossiersBundle:Mail/Envoi:base.relance.html.twig', ['message' => $mailRelance->getMessage()]
                    ), 'text/html'
                );

            $this->get('mailer')->send($message);

            $mailRelance->setDossier($dossier);

            // Insert the Mail into the DB
            $dossier->addMail($mailRelance);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dossier);
            $entityManager->flush();


            $this->addFlash('info', "La relance a bien été envoyée à " . $vacataire->getCivilite() . " " . $vacataire->getNom());
            return $this->redirectToRoute('homepage');
        }

        return $this->render("IutDossiersBundle:Mail/Envoi:relance_envoyer.html.twig", [
            'title' => "Relancer le dossier",
            'form' => $formModeleMail->createView(),
        ]);
    }

    public function ajouterModeleMailAction(Request $request, $id) {

        if ($id == -1) {
            $mail = new ModeleMail();
        } else {
            $mail = $this->getDoctrine()->getManager()->getRepository(ModeleMail::class)->find($id);

            if (!$mail) {
                throw $this->createNotFoundException("Le modèle de mail numéro $id n'existe pas.");
            }
        }

        $form = $this->createForm(ModeleMailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($mail);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le modèle de mail a bien été ajouté');
            return $this->redirectToRoute('modele-mail_liste');
        }

        return $this->render('IutDossiersBundle:Mail/Modele:modele_ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function listeModelesMailAction() {
        $mails = $this->getDoctrine()->getManager()->getRepository(ModeleMail::class);

        return $this->render('IutDossiersBundle:Mail/Modele:modele_liste.html.twig', [
                'mails' => $mails->findBy([], ['id' => 'ASC'])]
        );
    }

    public function afficherModeleMailAction($id) {
        $mail = $this->getDoctrine()->getManager()->getRepository(ModeleMail::class)->find($id);

        if (!$mail) {
            throw $this->createNotFoundException("Le modèle de mail numéro $id n'existe pas.");
        }

        return $this->render('IutDossiersBundle:Mail/Modele:modele_afficher.html.twig', [
            'mail' => $mail
        ]);
    }

    public function supprimerModeleMailAction($id) {
        $mail = $this->getDoctrine()->getManager()->getRepository(ModeleMail::class)->find($id);

        if (!$mail) {
            throw $this->createNotFoundException("Le modèle de mail numéro $id n'existe pas.");
        } else {
            $this->getDoctrine()->getManager()->remove($mail);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', "Le modèle de mail a bien été supprimé !");
        }

        return $this->redirectToRoute('modele-mail_liste');
    }

    /**
     * Parse a given mail to add dynamic data.
     * @param MailRelance $mail the mail to parse.
     * @param Dossier $dossier the dossier to get data.
     * @return MailRelance the parsed mail.
     */
    private function parseMail(MailRelance $mail, Dossier $dossier) {
        $data = [
            'civilite' => $dossier->getVacataire()->getCivilite(),
            'vacataire' => $dossier->getVacataire()->getNom(),
            'pieces'   => $dossier->getPieces()->toArray()
        ];

        $message = $mail->getMessage();
        foreach($data as $k => $d){
            if($k == "pieces") continue; //@TODO fix
            $message = str_replace("{{ ".$k." }}", $d, $message);
        }

        $mail->setMessage($message);
        return $mail;

    }

}
