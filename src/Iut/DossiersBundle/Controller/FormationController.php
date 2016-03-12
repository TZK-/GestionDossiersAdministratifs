<?php

namespace Iut\DossiersBundle\Controller;

use Iut\DossiersBundle\Entity\Formation;
use Iut\DossiersBundle\Form\FormationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormationController extends Controller {

    public function ajouterFormationAction(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        if($id == -1)
            $formation = new Formation();

        else{
            $formation = $entityManager->getRepository(Formation::class)->find($id);
            if(!$formation){
                throw $this->createNotFoundException("La formation numéro $id n'existe pas.");
            }
        }

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($formation);
            $entityManager->flush();

            if($id == -1)
                $message = "La formation a bien été ajoutée";
            else
                $message = "La formation a bien été modifiée";

            $this->addFlash('success', $message);
            return $this->redirectToRoute('formation_liste');
        }

        return $this->render('IutDossiersBundle:Formation:formation_ajouter.html.twig', [
            'title' => "Ajouter une formation",
            'form' => $form->createView()
        ]);
    }

    public function supprimerFormationAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $formation = $entityManager->getRepository(Formation::class)->find($id);

        if (!$formation) {
            throw $this->createNotFoundException("La formation numéro $id n'existe pas.");
        } else {
            $entityManager->remove($formation);
            $entityManager->flush();
            $this->addFlash('success', "La formation numéro " . $id . " a bien été supprimé !");
        }

        return $this->redirectToRoute('homepage');
    }

    public function listeFormationsAction() {
        $entityManager = $this->getDoctrine()->getManager();
        return $this->render('IutDossiersBundle:Formation:formation_liste.html.twig', [
            'formations' => $entityManager->getRepository(Formation::class)->findAll()
        ]);
    }

}
