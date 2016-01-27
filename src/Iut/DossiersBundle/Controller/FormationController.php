<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Iut\DossiersBundle\Entity\Formation;
use Iut\DossiersBundle\Form\FormationType;

class FormationController extends Controller {

    public function ajouterFormationAction(Request $request) {
        $formation = new Formation();

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManagerForClass(Formation::class);
            $entityManager->persist($formation);
            $entityManager->flush();

            $this->addFlash('success', 'La formation a bien été ajouté');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('IutDossiersBundle:Formation:ajouterFormation.html.twig', [
                    'title' => "Ajouter une formation",
                    'form' => $form->createView()
        ]);
    }

    public function supprimerFormationAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $formation = $entityManager->getRepository(Formation::class)->find($id);

        if (!$formation) {
            $this->addFlash('warning', "La formation numéro " . $id . " n'existe pas !");
        } else {
            $entityManager->remove($formation);
            $entityManager->flush();
            $this->addFlash('success', "La formation numéro " . $id . " a bien été supprimé !");
        }

        return $this->redirectToRoute('homepage');
    }

}

?>