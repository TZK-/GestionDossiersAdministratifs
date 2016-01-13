<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iut\DossiersBundle\Entity\Vacataire;
use Iut\DossiersBundle\Form\VacataireType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
        $vacataires = $this->getDoctrine()->getManager()->getRepository('IutDossiersBundle:Vacataire');

        return $this->render('IutDossiersBundle:Default:index.html.twig', ['vacataires' => $vacataires->findAll()]
        );
    }

    public function ajouterVacataireAction(Request $request, $id) {

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

}
