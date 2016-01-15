<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Iut\DossiersBundle\Entity\ModeleMail;
use Iut\DossiersBundle\Form\ModeleMailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Iut\DossiersBundle\Entity\MailRelance;
use Iut\DossiersBundle\Form\MailRelanceType;

class MailController extends Controller {

    public function envoyerMailAction(Request $request, $dossierId) {

        $modeleMail = new ModeleMail();
        $mailRelance = new MailRelance();

        $formModeleMail = $this->createFormBuilder($modeleMail)
                ->add('titre', EntityType::class, [
                    'class' => ModeleMail::class,
                    'choice_label' => "titre",
                    'multiple' => false])
                ->add('submit', SubmitType::class)
                ->getForm()
        ;

        $formMailRelance = $this->createForm(MailRelanceType::class, $mailRelance);

        $formModeleMail->handleRequest($request);
        $formMailRelance->handleRequest($request);

        if ($formModeleMail->isSubmitted() && $formModeleMail->isValid()) {

            $mailRelance->setTitre($modeleMail->getTitre()->getTitre());
            $mailRelance->setMessage($modeleMail->getTitre()->getMessage());

            $formMailRelance = $this->createForm(MailRelanceType::class, $mailRelance);

            return $this->render("IutDossiersBundle:Mail:envoyerMailRelance.html.twig", [
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
                            'IutDossiersBundle:Mail/Envoi:relance.html.twig', ['message' => $mailRelance->getMessage()]
                    ), 'text/html'
                    )
            ;

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('homepage');
        }

        return $this->render("IutDossiersBundle:Mail:envoyerMailRelance.html.twig", [
                    'title' => "Relancer le dossier",
                    'form' => $formModeleMail->createView(),
        ]);
    }

    public function ajouterModeleMailAction(Request $request, $id) {

        if ($id == -1) {
            $mail = new ModeleMail();
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $mail = $entityManager->getRepository(ModeleMail::class)->find($id);

            if (!$mail) {
                $this->addFlash('warning', "Le modèle de mail n'existe pas.");
                return $this->redirectToRoute('afficherListeModelesMail');
            }
        }

        $form = $this->createForm(ModeleMailType::class, $mail);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
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
            $this->addFlash('warning', "Le modèle de mail n'existe pas !");
            return $this->redirectToRoute('afficherListeModelesMail');
        }

        return $this->render('IutDossiersBundle:Mail:afficherModeleMail.html.twig', [
                    'mail' => $mail
        ]);
    }

    public function supprimerModeleMailAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $mail = $entityManager->getRepository(ModeleMail::class)->find($id);

        if (!$mail) {
            $this->addFlash('warning', "Le modèle de mail n'existe pas !");
        } else {
            $entityManager->remove($mail);
            $entityManager->flush();
            $this->addFlash('info', "Le modèle de mail a bien été supprimé !");
        }

        return $this->redirectToRoute('afficherListeModelesMail');
    }

}
