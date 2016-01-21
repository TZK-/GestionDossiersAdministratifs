<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Iut\DossiersBundle\Form\DossierType;
use Iut\DossiersBundle\Entity\Dossier;

class DossierController extends Controller {

    public function creerDossierAction(Request $request) {
        $dossier = new Dossier();
        $form = $this->createForm(DossierType::class, $dossier);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dossier);
            $entityManager->flush();

            $this->addFlash('info', "Le dossier a bien été crée !");

            return $this->redirectToRoute('homepage');
        }

        return $this->render('IutDossiersBundle:Dossier:creerDossier.html.twig', [
                'form' => $form->createView(),
                    'title' => "Créer un dossier"
        ]);
    }

}
