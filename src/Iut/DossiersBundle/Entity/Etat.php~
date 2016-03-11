<?php

namespace Iut\DossiersBundle\Entity;

/**
 * Etat
 */
class Etat {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $dossiers;

    /**
     * Constructor
     */
    public function __construct() {
        $this->dossiers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get libelle
     *
     * @return string
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Etat
     */
    public function setLibelle($libelle) {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Add dossier
     *
     * @param \Iut\DossiersBundle\Entity\Dossier $dossier
     *
     * @return Etat
     */
    public function addDossier(\Iut\DossiersBundle\Entity\Dossier $dossier) {
        $this->dossiers[] = $dossier;

        return $this;
    }

    /**
     * Remove dossier
     *
     * @param \Iut\DossiersBundle\Entity\Dossier $dossier
     */
    public function removeDossier(\Iut\DossiersBundle\Entity\Dossier $dossier) {
        $this->dossiers->removeElement($dossier);
    }

    /**
     * Get dossiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossiers() {
        return $this->dossiers;
    }
}
