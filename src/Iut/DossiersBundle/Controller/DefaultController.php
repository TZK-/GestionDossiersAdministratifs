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

        return $this->render('IutDossiersBundle:Default:index.html.twig', ['vacataires' => $vacataires->findAll()]
        );
    }

    public function ajouterVacataireAction(Request $request) {

        $vacataire = new Vacataire();

        $form = $this->createForm(VacataireType::class, $vacataire);
        if($request->isMethod('POST')){
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

    public function ajouterModeleMailAction(Request $request) {

        $mail = new ModeleMail();

        $form = $this->createForm(ModeleMailType::class, $mail);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            $entytymanager = $this->getDoctrine()->getManagerForClass(ModeleMail::class);
            $entytymanager->persist($mail);
            $entytymanager->flush();
            $this->addFlash('success', 'Le modèle de mail a bien été ajouté');
            return $this->redirectToRoute('homepage');

        }

        return $this->render('IutDossiersBundle:Default:ajouterModeleMail.html.twig', [
                    'title' => "Ajouter un modèle de mail",
                    'form' => $form->createView()
        ]);
    }
    
    public function consulterModeleMailAction() {
        $mail = $this->getDoctrine()->getManager()->getRepository('IutDossiersBundle:ModeleMail');

        return $this->render('IutDossiersBundle:Default:consulterModeleMail.html.twig', [
            'title' => "Ajouter un modèle de mail",
            'modeleMail' => $mail->findAll()]
        );
    }

}
