<?php

namespace Iut\DossiersBundle\Entity;

/**
 * ListeMailsDossier
 */
class ListeMailsDossier
{

    /**
     * @var int
     */
    private $dossierId;

    /**
     * @var int
     */
    private $mailId;

    /**
     * Set dossierId
     *
     * @param integer $dossierId
     *
     * @return ListeMailsDossier
     */
    public function setDossierId($dossierId)
    {
        $this->dossierId = $dossierId;

        return $this;
    }

    /**
     * Get dossierId
     *
     * @return int
     */
    public function getDossierId()
    {
        return $this->dossierId;
    }

    /**
     * Set mailId
     *
     * @param integer $mailId
     *
     * @return ListeMailsDossier
     */
    public function setMailId($mailId)
    {
        $this->mailId = $mailId;

        return $this;
    }

    /**
     * Get mailId
     *
     * @return int
     */
    public function getMailId()
    {
        return $this->mailId;
    }
}
