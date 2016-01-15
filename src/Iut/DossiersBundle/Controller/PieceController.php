<?php

namespace Iut\DossiersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Iut\DossiersBundle\Entity\Piece;
use Iut\DossiersBundle\Form\PieceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PieceController extends Controller {

    public function ajouterPieceAction(Request $request) {
        $piece = new Piece();

        $form = $this->createForm(PieceType::class, $piece);
        if ($request->isMethod('POST')) {
            $form->submit($request);

            $entityManager = $this->getDoctrine()->getManagerForClass(Piece::class);
            $entityManager->persist($piece);
            $entityManager->flush();

            $this->addFlash('success', 'La pièce a bien été ajouté');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('IutDossiersBundle:Default:ajouterPiece.html.twig', [
                    'title' => "Ajouter une pièce",
                    'form' => $form->createView()
        ]);
    }

    public function supprimerPieceAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $piece = $entityManager->getRepository(Piece::class);

        $piece = $piece->find($id);

        if (!$piece) {
            $this->addFlash('danger', "La pièce numéro " . $id . " n'existe pas !");
        } else {
            $entityManager->remove($piece);
            $entityManager->flush();
            $this->addFlash('success', "La pièce numéro " . $id . " a bien été supprimé !");
        }

        return $this->redirectToRoute('homepage');
    }

}

?>