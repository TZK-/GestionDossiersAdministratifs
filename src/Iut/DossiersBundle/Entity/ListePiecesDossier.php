<?php

namespace Iut\DossiersBundle\Entity;

/**
 * ListePiecesDossier
 */
class ListePiecesDossier
{

    /**
     * @var int
     */
    private $dossierId;

    /**
     * @var int
     */
    private $formationId;

    /**
     * Set dossierId
     *
     * @param integer $dossierId
     *
     * @return ListePiecesDossier
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
     * Set formationId
     *
     * @param integer $formationId
     *
     * @return ListePiecesDossier
     */
    public function setFormationId($formationId)
    {
        $this->formationId = $formationId;

        return $this;
    }

    /**
     * Get formationId
     *
     * @return int
     */
    public function getFormationId()
    {
        return $this->formationId;
    }
}
