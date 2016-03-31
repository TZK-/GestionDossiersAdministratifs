<?php

namespace Iut\DossiersBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Dossier
 */
class Dossier {

    /**
     * @var int
     */
    private $id;

    /**
     * @var Etat
     */
    private $etat;

    /**
     * @var Vacataire
     */
    private $vacataire;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pieces;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $formation;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $mails;

    /**
     * Constructor
     */
    public function __construct() {
        $this->date = new \DateTime();
        $this->pieces = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get etat
     *
     * @return Etat
     */
    public function getEtat() {
        return $this->etat;
    }

    /**
     * Set etat
     *
     * @param Etat $etat
     *
     * @return Dossier
     */
    public function setEtat(Etat $etat = null) {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get vacataire
     *
     * @return Vacataire
     */
    public function getVacataire() {
        return $this->vacataire;
    }

    /**
     * Set vacataire
     *
     * @param Vacataire $vacataire
     *
     * @return Dossier
     */
    public function setVacataire(Vacataire $vacataire = null) {
        $this->vacataire = $vacataire;

        return $this;
    }

    /**
     * Add piece
     *
     * @param Piece $piece
     *
     * @return Dossier
     */
    public function addPiece(Piece $piece) {
        $this->pieces[] = $piece;

        return $this;
    }

    /**
     * Remove all the pieces
     */
    public function removeAllPieces() {
        foreach ($this->pieces as $p) {
            $this->removePiece($p);
        }
    }

    /**
     * Remove piece
     *
     * @param Piece $piece
     */
    public function removePiece(Piece $piece) {
        $this->pieces->removeElement($piece);
    }

    /**
     * Get pieces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPieces() {
        return $this->pieces;
    }

    /**
     * Get formation
     *
     * @return Formation
     */
    public function getFormation() {
        return $this->formation;
    }

    /**
     * Set formation
     *
     * @param Formation $formation
     *
     * @return Dossier
     */
    public function setFormation(Formation $formation = null) {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Dossier
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Add mail
     *
     * @param \Iut\DossiersBundle\Entity\MailRelance $mail
     *
     * @return Dossier
     */
    public function addMail(\Iut\DossiersBundle\Entity\MailRelance $mail) {
        $this->mails[] = $mail;

        return $this;
    }

    /**
     * Remove mail
     *
     * @param \Iut\DossiersBundle\Entity\MailRelance $mail
     */
    public function removeMail(\Iut\DossiersBundle\Entity\MailRelance $mail) {
        $this->mails->removeElement($mail);
    }

    public function getLastMail() {
        return $this->getMails()->last();
    }

    /**
     * Get mails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMails() {
        return $this->mails;
    }
}
