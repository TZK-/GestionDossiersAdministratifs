<?php

namespace Iut\DossiersBundle\Entity;

/**
 * MailRelance
 */
class MailRelance
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Iut\DossiersBundle\Entity\Dossier
     */
    private $dossier;

    function __construct() {
        $this->date = new \DateTime();
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
     * Get titre
     *
     * @return string
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return MailRelance
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return MailRelance
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return MailRelance
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return \Iut\DossiersBundle\Entity\Dossier
     */
    public function getDossier() {
        return $this->dossier;
    }

    /**
     * Set dossier
     *
     * @param \Iut\DossiersBundle\Entity\Dossier $dossier
     *
     * @return MailRelance
     */
    public function setDossier(\Iut\DossiersBundle\Entity\Dossier $dossier = null) {
        $this->dossier = $dossier;

        return $this;
    }
}
