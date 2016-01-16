<?php

namespace Iut\DossiersBundle\Entity;

/**
 * Dossier
 */
class Dossier
{
    /**
     * @var int
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var \Iut\DossiersBundle\Entity\Etat
     */
    private $etat;


    /**
     * Set etat
     *
     * @param \Iut\DossiersBundle\Entity\Etat $etat
     *
     * @return Dossier
     */
    public function setEtat(\Iut\DossiersBundle\Entity\Etat $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \Iut\DossiersBundle\Entity\Etat
     */
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * @var \Iut\DossiersBundle\Entity\Vacataire
     */
    private $vacataire;


    /**
     * Set vacataire
     *
     * @param \Iut\DossiersBundle\Entity\Vacataire $vacataire
     *
     * @return Dossier
     */
    public function setVacataire(\Iut\DossiersBundle\Entity\Vacataire $vacataire = null)
    {
        $this->vacataire = $vacataire;

        return $this;
    }

    /**
     * Get vacataire
     *
     * @return \Iut\DossiersBundle\Entity\Vacataire
     */
    public function getVacataire()
    {
        return $this->vacataire;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pieces;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pieces = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add piece
     *
     * @param \Iut\DossiersBundle\Entity\Piece $piece
     *
     * @return Dossier
     */
    public function addPiece(\Iut\DossiersBundle\Entity\Piece $piece)
    {
        $this->pieces[] = $piece;

        return $this;
    }

    /**
     * Remove piece
     *
     * @param \Iut\DossiersBundle\Entity\Piece $piece
     */
    public function removePiece(\Iut\DossiersBundle\Entity\Piece $piece)
    {
        $this->pieces->removeElement($piece);
    }

    /**
     * Get pieces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPieces()
    {
        return $this->pieces;
    }
}
