<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iut\DossiersBundle\Entity\Vacataire;

use Iut\DossiersBundle\Entity\Formation;
use Iut\DossiersBundle\Entity\Etat;
use Iut\DossiersBundle\Entity\Dossier;
use Iut\DossiersBundle\Form\VacataireType;
use Symfony\Component\HttpFoundation\Request;

class VacataireController extends Controller {

    public function indexAction() {
        $entityManager = $this->getDoctrine()->getManager();
        return $this->render("IutDossiersBundle:Vacataire:listeVacataires.html.twig", [
            'vacataires' => $entityManager->getRepository(Vacataire::class)->findAll(),
            'formations' => $entityManager->getRepository(Formation::class)->findAll(),
            'etats' => $entityManager->getRepository(Etat::class)->findAll(),
            'dossiers' => $entityManager->getRepository(Dossier::class)->findAll()
        ]);
    }

    /* TESTS */

    public function addVacTestAction() {
        $vacataire1 = new Vacataire();
        $vacataire1->setNom("Albert");
        $vacataire1->setPrenom("Jean");
        $vacataire1->setMail("jean.albert@gmail.com");
        
        $vacataire2 = new Vacataire();
        $vacataire2->setNom("Hugue");
        $vacataire2->setPrenom("Edward");
        $vacataire2->setMail("edward.hugue@hotmail.fr");

        $formations1 = new Formation;
        $formations1->setLibelle("Informatique");
        $vacataire1->addFormation($formations1);

        $formations2 = new Formation;
        $formations2->setLibelle("TC");
        $vacataire2->addFormation($formations2);

        $formations = new Formation;
        $formations->setLibelle("GEA");  
        $vacataire2->addFormation($formations);
        $vacataire1->addFormation($formations);

        $etat1 = new Etat();
        $etat1->setLibelle("Incomplet");
        $etat2 = new Etat();
        $etat2->setLibelle("Inexistant");
        $etat3 = new Etat();
        $etat3->setLibelle("Complet");
        
        $dossier1 = new Dossier();
        $dossier1->setEtat($etat1);
        $dossier1->setVacataire($vacataire1);
        
        $dossier2 = new Dossier();
        $dossier2->setEtat($etat2);
        $dossier2->setVacataire($vacataire2);
        

        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($vacataire1);
        $entityManager->persist($vacataire2);
        $entityManager->persist($etat1);
        $entityManager->persist($etat2);
        $entityManager->persist($etat3);
        $entityManager->persist($dossier1);
        $entityManager->persist($dossier2);
        $entityManager->flush();
        return $this->redirectToRoute('homepage');
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
