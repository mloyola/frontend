<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Opcionsubcategoria
 */
class Opcionsubcategoria
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $descripcion;

    public function __toString()
    {
        return $this->getDescripcion();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Opcionsubcategoria
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
