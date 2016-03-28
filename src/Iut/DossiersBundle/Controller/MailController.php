<?php

namespace Iut\DossiersBundle\Controller;

use Iut\DossiersBundle\Entity\Dossier;
use Iut\DossiersBundle\Entity\MailRelance;
use Iut\DossiersBundle\Entity\ModeleMail;
use Iut\DossiersBundle\Form\MailRelanceType;
use Iut\DossiersBundle\Form\ModeleMailListeType;
use Iut\DossiersBundle\Form\ModeleMailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MailController extends Controller {

    public function envoyerRelanceAction(Request $request, $dossierId) {

        $dossier = $this->getDoctrine()->getRepository(Dossier::class)->find($dossierId);
        if(!$dossier)
            throw $this->createNotFoundException("Le dossier numéro $dossierId n'existe pas.");

        $modeleMail = new ModeleMail();
        $mailRelance = new MailRelance();

        $formModeleMail = $this->createForm(ModeleMailListeType::class, $modeleMail);

        $formMailRelance = $this->createForm(MailRelanceType::class, $mailRelance);

        $formModeleMail->handleRequest($request);
        $formMailRelance->handleRequest($request);

        $vacataire = $dossier->getVacataire();

        if ($formModeleMail->isSubmitted() && $formModeleMail->isValid()) {
            $mailRelance->setTitre($modeleMail->getTitre()->getTitre()); // @TODO Wtf ?
            $mailRelance->setMessage($modeleMail->getTitre()->getMessage());

            $mailRelance = $this->parseMail($mailRelance, $dossier);

            $formMailRelance = $this->createForm(MailRelanceType::class, $mailRelance);

            return $this->render("IutDossiersBundle:Mail/Envoi:relance_envoyer.html.twig", [
                'title' => "Relancer le dossier",
                'form' => $formMailRelance->createView(),
            ]);
        }

        if ($formMailRelance->isSubmitted() && $formMailRelance->isValid()) {

            $this->sendMail($mailRelance->getTitre(), $mailRelance->getMessage(), $vacataire->getMail());

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

    /**
     * Parse a given mail to add dynamic data.
     * @param MailRelance $mail the mail to parse.
     * @param Dossier $dossier the dossier to get data.
     * @return MailRelance the parsed mail.
     */
    private function parseMail(MailRelance $mail, Dossier $dossier) {
        $args = [
            'civilite' => $dossier->getVacataire()->getCivilite(),
            'vacataire' => $dossier->getVacataire()->getNom(),
            'pieces' => $dossier->getPieces()
        ];

        $message = $mail->getMessage();
        $pieces = "";

        $pieceNumber = 0;
        foreach ($args as $key => $data) {
            if ($key === "pieces") {
                foreach ($data as $piece) {
                    $pieceNumber++;
                    // If it is the last piece to display, relace the comma by a point
                    $pieces .= (count($data) != $pieceNumber) ? "$piece, " : "et $piece.";
                }
            }
            else {
                $message = str_replace("{{ " . $key . " }}", $data, $message);
            }

        }

        $message = str_replace("{{ pieces }}", $pieces, $message);

        $mail->setMessage($message);
        return $mail;
    }

    /**
     * Envoie un E-Mail paramétrable
     * @param $subject string Le sujet du mail
     * @param $message string Le contenu du mail
     * @param $to string L'adresse du destinataire
     * @param $from string l'adresse d'expédition. Si $from est null, alors récupère l'adresse définie dans config.yml
     */
    private function sendMail($subject, $message, $to, $from = null) {
        /* Envoi du mail */
        $mail = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom(($from == null) ? $this->getParameter('swiftmailer.sender_address') : $from)
            ->setBody(
                $this->renderView(
                    'IutDossiersBundle:Mail/Envoi:base.relance.html.twig', ['message' => $message]
                ), 'text/html')
            ->addPart(
                $this->renderView(
                    'IutDossiersBundle:Mail/Envoi:base.relance.txt.twig', ['message' => strip_tags($message)]
                ),
                'text/plain'
            );

        $this->get('mailer')->send($mail);
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

    public function afficherRelanceAction(Request $request, $id) {
        // If the request is not from AJAX, redirect.
        if(!$request->isXmlHttpRequest())
            return $this->redirectToRoute("homepage");
        $mail = $this->getDoctrine()->getManager()->getRepository(MailRelance::class)->find($id);
        $response = new JsonResponse();
        if(!$mail)
            $response->setData(null);
        else
            $response->setData([
                'message' => $mail->getMessage(),
                'date' => $mail->getDate()->format("d/m/y")
            ]);
        return $response;
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

}
