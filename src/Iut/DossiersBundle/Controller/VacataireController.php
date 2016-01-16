<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iut\DossiersBundle\Entity\Vacataire;
use Iut\DossiersBundle\Form\VacataireType;
use Symfony\Component\HttpFoundation\Request;

class VacataireController extends Controller {

    public function indexAction() {
        $vacataires = $this->getDoctrine()->getManager()->getRepository(Vacataire::class);

        return $this->render('IutDossiersBundle:Vacataire:index.html.twig', [
                    'vacataires' => $vacataires->findAll(),
                    'title' => "Accueil"
        ]);
    }

    /* TESTS */

    private function addVacTest(){
        $vacataire = new Vacataire();
        $vacataire->setNom("Albert");
        $vacataire->setPrenom("Jean");
        $vacataire->setMail("jean.albert@gmail.com");

        $formations = new \Iut\DossiersBundle\Entity\Formation;
        $formations->setLibelle("Informatique");

        $vacataire->addFormation($formations);

        $formations = new \Iut\DossiersBundle\Entity\Formation;
        $formations->setLibelle("GEA");

        $vacataire->addFormation($formations);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($vacataire);
        $entityManager->flush();
    }

    /* END TESTS */

    public function afficherListeVacatairesAction(){
        $entityManager = $this->getDoctrine()->getManager();
        return $this->render("IutDossiersBundle:Vacataire:listeVacataires.html.twig", [
            'vacataires' => $entityManager->getRepository(Vacataire::class)->findAll()
        ]);
    }

    public function ajouterVacataireAction(Request $request, $id) {

        if ($id == -1) {
            $vacataire = new Vacataire();
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $vacataire = $entityManager->getRepository(Vacataire::class)->find($id);

            if (!$vacataire) {
                $this->addFlash('warning', "Le vacataire numero $id n'existe pas.");
                return $this->redirectToRoute('homepage');
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

        return $this->render('IutDossiersBundle:Vacataire:ajouterVacataire.html.twig', [
                    'title' => "Ajouter un vacataire",
                    'form' => $form->createView()
        ]);
    }

    public function supprimerVacataireAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $vacataire = $entityManager->getRepository(Vacataire::class)->find($id);

        if (!$vacataire) {
            $this->addFlash('danger', "Le Vacataire numéro " . $id . " n'existe pas !");
        } else {
            $entityManager->remove($vacataire);
            $entityManager->flush();
            $this->addFlash('success', "Le vacataire numéro " . $id . " a bien été supprimé !");
        }

        return $this->redirectToRoute('homepage');
    }

}
