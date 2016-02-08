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

    public function listeDossierAction() {
        $entityManager = $this->getDoctrine()->getManager();
        return $this->render("IutDossiersBundle:Dossier:dossier_liste.html.twig", [
            'dossiers' => $entityManager->getRepository(Dossier::class)->findAll()
        ]);
    }
}
