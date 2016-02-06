<?php

namespace Iut\DossiersBundle\Entity;

/**
 * Vacataire
 */
class Vacataire
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $mail;
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $formations;
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $dossiers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formations = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Vacataire
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Vacataire
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Vacataire
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Add formation
     *
     * @param \Iut\DossiersBundle\Entity\Formation $formation
     *
     * @return Vacataire
     */
    public function addFormation(\Iut\DossiersBundle\Entity\Formation $formation)
    {
        if(!$this->formations->contains($formation))
            $this->formations[] = $formation;
        return $this;
    }

    /**
     * Remove formation
     *
     * @param \Iut\DossiersBundle\Entity\Formation $formation
     */
    public function removeFormation(\Iut\DossiersBundle\Entity\Formation $formation)
    {
        $this->formations->removeElement($formation);
    }

    /**
     * Get formations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormations()
    {
        return $this->formations;
    }

    /**
     * Add dossier
     *
     * @param \Iut\DossiersBundle\Entity\Dossier $dossier
     *
     * @return Vacataire
     */
    public function addDossier(\Iut\DossiersBundle\Entity\Dossier $dossier)
    {
        $this->dossiers[] = $dossier;

        return $this;
    }

    /**
     * Remove dossier
     *
     * @param \Iut\DossiersBundle\Entity\Dossier $dossier
     */
    public function removeDossier(\Iut\DossiersBundle\Entity\Dossier $dossier)
    {
        $this->dossiers->removeElement($dossier);
    }

    /**
     * Get dossiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossiers()
    {
        return $this->dossiers;
    }

    function __toString() {
        return "$this->prenom $this->nom";
    }

}
