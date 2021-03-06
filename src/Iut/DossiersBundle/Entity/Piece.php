<?php

namespace Iut\DossiersBundle\Entity;

/**
 * Piece
 */
class Piece {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $libelle;


    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    function __toString() {
        return (string)$this->getLibelle();
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
     * @return Piece
     */
    public function setLibelle($libelle) {
        $this->libelle = $libelle;

        return $this;
    }


}
