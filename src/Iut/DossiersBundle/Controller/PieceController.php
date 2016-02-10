<?php

namespace Iut\DossiersBundle\Controller;

use Iut\DossiersBundle\Entity\Piece;
use Iut\DossiersBundle\Form\PieceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PieceController extends Controller {

    public function ajouterPieceAction(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        if ($id == -1)
            $piece = new Piece();
        else {
            $piece = $entityManager->getRepository(Piece::class)->find($id);
            if (!$piece) {
                $this->addFlash("warning", "La piece $id n'existe pas !");
                $this->redirect("piece_liste");
            }
        }

        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($piece);
            $entityManager->flush();

            $message = "La pièce a bien été ";
            if ($id == -1)
                $message .= "ajoutée";
            else
                $message .= "modifiée";
            $message .= "!";

            $this->addFlash('success', $message);
            return $this->redirectToRoute('piece_liste');
        }

        return $this->render('IutDossiersBundle:Piece:piece_ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function supprimerPieceAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $piece = $entityManager->getRepository(Piece::class)->find($id);

        if (!$piece) {
            $this->addFlash('warning', "La pièce $id n'existe pas !");
        } else {
            $entityManager->remove($piece);
            $entityManager->flush();
            $this->addFlash('success', 'La pièce "' . $piece->getLibelle() . '" a bien été supprimé !');
        }

        return $this->redirectToRoute('homepage');
    }

    public function listePiecesAction() {
        $entityManager = $this->getDoctrine()->getManager();
        return $this->render('IutDossiersBundle:Piece:piece_liste.html.twig', [
            'pieces' => $entityManager->getRepository(Piece::class)->findAll()
        ]);
    }

}
