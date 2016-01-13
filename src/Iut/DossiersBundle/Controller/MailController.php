<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Iut\DossiersBundle\Entity\MailRelance;
use Iut\DossiersBundle\Form\MailRelanceType;

class MailController extends Controller {

    public function envoyerMailAction(Request $request, $dossierId) {

        /* @TODO
         * Récupérer le dossier dans la BDD
         * Charger le mail suivant les infos du dossier
         * Envoyer le mail
         */

        $mail = new MailRelance();

        $form = $this->createForm(MailRelanceType::class, $mail);

        $message = \Swift_Message::newInstance()
            ->setSubject($mail->getTitre())
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView("Mail/relance.html.twig", [
                    'mail' => $mail,
                    'dossier' => $dossier
                ]),
                'text/html'
            )
        ;

        $this->get('mailer')->send($message);
    }

}
