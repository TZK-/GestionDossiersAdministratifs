<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Iut\DossiersBundle\Entity\Piece;
use Iut\DossiersBundle\Form\PieceType;

class PieceController extends Controller {

    public function ajouterPieceAction(Request $request) {
        $piece = new Piece();

        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManagerForClass(Piece::class);
            $entityManager->persist($piece);
            $entityManager->flush();

            $this->addFlash('success', 'La pièce a bien été ajouté');
            return $this->redirectToRoute('homepage');
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
