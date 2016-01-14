<?php

namespace Iut\DossiersBundle\Entity;

/**
 * ListeFormationsVacataire
 */
class ListeFormationsVacataire
{

    /**
     * @var int
     */
    private $vacataireId;

    /**
     * @var int
     */
    private $formationId;

    /**
     * Set vacataireId
     *
     * @param integer $vacataireId
     *
     * @return ListeFormationsVacataire
     */
    public function setVacataireId($vacataireId)
    {
        $this->vacataireId = $vacataireId;

        return $this;
    }

    /**
     * Get vacataireId
     *
     * @return int
     */
    public function getVacataireId()
    {
        return $this->vacataireId;
    }

    /**
     * Set formationId
     *
     * @param integer $formationId
     *
     * @return ListeFormationsVacataire
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
