<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iut\DossiersBundle\Entity\Vacataire;
use Iut\DossiersBundle\Form\VacataireType;
use Iut\DossiersBundle\Entity\ModeleMail;
use Iut\DossiersBundle\Form\ModeleMailType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
        $vacataires = $this->getDoctrine()->getManager()->getRepository('IutDossiersBundle:Vacataire');

        return $this->render('IutDossiersBundle:Default:index.html.twig', [
            'vacataires' => $vacataires->findAll(),
            'title' => "Accueil"
            ]
        );
    }

    public function ajouterVacataireAction(Request $request) {

        $vacataire = new Vacataire();

        $form = $this->createForm(VacataireType::class, $vacataire);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $entytymanager = $this->getDoctrine()->getManagerForClass(Vacataire::class);
            $entytymanager->persist($vacataire);
            $entytymanager->flush();
            $this->addFlash('success', 'Le vacataire a bien été ajouté');
            return $this->redirectToRoute('homepage');
            
        }

        return $this->render('IutDossiersBundle:Default:ajouterVacataire.html.twig', [
                    'title' => "Ajouter un vacataire",
                    'form' => $form->createView()
        ]);
    }
    
     public function supprimerVacataireAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $vacataire = $entityManager->getRepository(Vacataire::class);

        $vacataire = $vacataire->find($id);
        
        if (!$vacataire) {
            $this->addFlash('danger', "Le Vacataire numéro " . $id . " n'existe pas !");
        }else{
            $entityManager->remove($vacataire);
            $entityManager->flush();
            $this->addFlash('success', "Le vacataire numéro " . $id . " a bien été supprimé !");
        }
        
        return $this->redirectToRoute('homepage');
     }
    
    
    
    public function ajouterModeleMailAction(Request $request) {

        $mail = new ModeleMail();

        $form = $this->createForm(ModeleMailType::class, $mail);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            $entytymanager = $this->getDoctrine()->getManagerForClass(ModeleMail::class);
            $entytymanager->persist($mail);
            $entytymanager->flush();
            $this->addFlash('success', 'Le modèle de mail a bien été ajouté');
            return $this->redirectToRoute('consulterModeleMail');

        }

        return $this->render('IutDossiersBundle:Default:ajouterModeleMail.html.twig', [
                    'title' => "Ajouter un modèle de mail",
                    'form' => $form->createView()
        ]);
    }
    
    public function consulterModeleMailAction() {
        $mails = $this->getDoctrine()->getManager()->getRepository('IutDossiersBundle:ModeleMail');

        return $this->render('IutDossiersBundle:Default:consulterModeleMail.html.twig', [
            'mails' => $mails->findBy([], ['id' => 'ASC'])]
        );
    }

    public function afficherModeleMailAction($id){
        $entityManager = $this->getDoctrine()->getManager();
        $mails = $entityManager->getRepository(ModeleMail::class);

        $mail = $mails->find($id);

        if (!$mail) {
            $this->addFlash('danger', "Le mail n'existe pas !");
            return $this->redirectToRoute('consulterModeleMail');
        }

        return $this->render('IutDossiersBundle:Default:afficherModeleMail.html.twig', [
            'mail' => $mail
        ]);
    }


    public function supprimerModeleMailAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $mails = $entityManager->getRepository(ModeleMail::class);

        $mail = $mails->find($id);

        if (!$mail) {
            $this->addFlash('danger', "Le mail n'existe pas !");
        }else{
            $entityManager->remove($mail);
            $entityManager->flush();
            $this->addFlash('success', "Le mail a bien été supprimé !");
        }

        return $this->redirectToRoute('consulterModeleMail');
    }

}

