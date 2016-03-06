<?php

namespace Iut\DossiersBundle\Controller;

use Iut\DossiersBundle\Entity\Dossier;
use Iut\DossiersBundle\Form\DossierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DossierController extends Controller {

    public function ajouterDossierAction(Request $request, $id) {

        if ($id == -1)
            $dossier = new Dossier();
        else {
            $dossier = $this->getDoctrine()->getManager()->getRepository(Dossier::class)->find($id);
            if (!$dossier) {
                $this->addFlash('warning', "Le dossier numéro $id n'existe pas");
                return $this->redirectToRoute('homepage');
            }
        }

        $form = $this->createForm(DossierType::class, $dossier);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $selectedFormation = $form->get('formation')->getData();
            $vacataire = $form->get('vacataire')->getData();

            $entityManager = $this->getDoctrine()->getManager();

            if (!$vacataire->getFormations()->contains($selectedFormation)) {
                $vacataire->addFormation($selectedFormation);
            }

            $entityManager->persist($dossier);

            $entityManager->flush();

            $this->addFlash('info', "Le dossier a bien été crée !");

            return $this->redirectToRoute('homepage');
        }

        return $this->render('IutDossiersBundle:Dossier:dossier_ajouter.html.twig', [
            'form' => $form->createView(),
            'title' => "Créer un dossier"
        ]);
    }

    public function listeDossierAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->getRepository(Dossier::class)->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10 // limit
        );

        return $this->render("IutDossiersBundle:Dossier:dossier_liste.html.twig", [
            'pagination' => $pagination
        ]);
    }

    public function historiqueDossierAction() {
        $entityManager = $this->getDoctrine()->getManager();
        return $this->render("IutDossiersBundle:Dossier:dossier_historique.html.twig", [
            'dossiers' => $entityManager->getRepository(Dossier::class)->findClosedDossier()
        ]);
    }
}
