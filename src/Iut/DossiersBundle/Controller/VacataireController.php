<?php

namespace Iut\DossiersBundle\Controller;

use Iut\DossiersBundle\Entity\Vacataire;
use Iut\DossiersBundle\Form\VacataireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VacataireController extends Controller {

    public function afficherListeVacatairesAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->getRepository(Vacataire::class)->findAllDossiersAndFormations();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10 // limit
        );

        return $this->render("IutDossiersBundle:Vacataire:vacataire_liste.html.twig", [
                    'pagination' => $pagination
        ]);
    }

    public function ajouterVacataireAction(Request $request, $id) {

        if ($id == -1) {
            $vacataire = new Vacataire();
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $vacataire = $entityManager->getRepository(Vacataire::class)->find($id);

            if (!$vacataire) {
                throw $this->createNotFoundException("Le vacataire numéro $id n'existe pas.");
            }
        }

        $form = $this->createForm(VacataireType::class, $vacataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entytymanager = $this->getDoctrine()->getManagerForClass(Vacataire::class);
            $entytymanager->persist($vacataire);
            $entytymanager->flush();
            if ($id == -1)
                $this->addFlash('success', 'Le vacataire a bien été ajouté.');
            else
                $this->addFlash('success', 'Le vacataire a bien été modifié.');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('IutDossiersBundle:Vacataire:vacataire_ajouter.html.twig', [
                    'title' => "Ajouter un vacataire",
                    'form' => $form->createView()
        ]);
    }

    public function supprimerVacataireAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $vacataire = $entityManager->getRepository(Vacataire::class)->find($id);

        if (!$vacataire) {
            throw $this->createNotFoundException("Le vacataire numéro $id n'existe pas.");
        } else {
            $entityManager->remove($vacataire);
            $entityManager->flush();
            $this->addFlash('success', "Le vacataire numéro " . $id . " a bien été supprimé !");
        }

        return $this->redirectToRoute('homepage');
    }

}
