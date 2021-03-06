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
                throw $this->createNotFoundException("Le dossier numéro $id n'existe pas.");
            }
        }

        $form = $this->createForm(DossierType::class, $dossier);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Récupére les données du formulaire (sous forme d'objets)
            $selectedFormation = $form->get('formation')->getData();
            $vacataire = $form->get('vacataire')->getData();
            $etat = $form->get('etat')->getData();

            $entityManager = $this->getDoctrine()->getManager();

            if (!$vacataire->getFormations()->contains($selectedFormation)) {
                $vacataire->addFormation($selectedFormation);
            }

            // Si l'état == 'complet', on supprime toutes les pièces manquantes pour ce dossier
            if ($etat->getLibelle() == "Complet") {
                $dossier->removeAllPieces();
            }

            $entityManager->persist($dossier);

            $entityManager->flush();

            $this->addFlash('info', "Le dossier a bien été crée !");

            return $this->redirectToRoute('homepage');
        }

        return $this->render(($id == -1) ? 'IutDossiersBundle:Dossier:dossier_ajouter.html.twig' :
            'IutDossiersBundle:Dossier:dossier_modifier.html.twig', [
            'form' => $form->createView(),
            'dossier' => $dossier
        ]);
    }

    public function listeDossierAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $dossierRepository = $entityManager->getRepository(Dossier::class);

        $query = $dossierRepository->findAll();

        $paginator = $this->get('knp_paginator');
        $dossier = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10 // limit
        );

        return $this->render("IutDossiersBundle:Dossier:dossier_liste.html.twig", [
            'dossiers' => $dossier,
        ]);
    }

    public function historiqueDossierAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->getRepository(Dossier::class)->findClosedDossier();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render("IutDossiersBundle:Dossier:dossier_historique.html.twig", [
            'dossiers' => $pagination
        ]);
    }
}
