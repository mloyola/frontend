<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Verificodseg
 */
class Verificodseg
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $descripcorta;

    /**
     * @var string
     */
    private $descripcion;


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
     * Set codigo
     *
     * @param string $codigo
     * @return Verificodseg
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descripcorta
     *
     * @param string $descripcorta
     * @return Verificodseg
     */
    public function setDescripcorta($descripcorta)
    {
        $this->descripcorta = $descripcorta;
    
        return $this;
    }

    /**
     * Get descripcorta
     *
     * @return string 
     */
    public function getDescripcorta()
    {
        return $this->descripcorta;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Verificodseg
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
