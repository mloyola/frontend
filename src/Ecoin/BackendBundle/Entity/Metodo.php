<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Metodo
 */
class Metodo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $metodo;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="Ecoin\BackendBundle\Entity\Procesador", mappedBy="metodos")
    */
    private $procesadores;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->procesadores = new \Doctrine\Common\Collections\ArrayCollection();
    }
        
    public function __toString()
    {        
        return  $this->getMetodo();
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
     * Set metodo
     *
     * @param string $metodo
     * @return Metodo
     */
    public function setMetodo($metodo)
    {
        $this->metodo = $metodo;
    
        return $this;
    }

    /**
     * Get metodo
     *
     * @return string 
     */
    public function getMetodo()
    {
        return $this->metodo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Metodo
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

    /**
     * Add procesadores
     *
     * @param \Ecoin\BackendBundle\Entity\Procesador $procesadores
     * @return Metodo
     */
    public function addProcesadore(\Ecoin\BackendBundle\Entity\Procesador $procesadores)
    {
        $this->procesadores[] = $procesadores;
    
        return $this;
    }

    /**
     * Remove procesadores
     *
     * @param \Ecoin\BackendBundle\Entity\Procesador $procesadores
     */
    public function removeProcesadore(\Ecoin\BackendBundle\Entity\Procesador $procesadores)
    {
        $this->procesadores->removeElement($procesadores);
    }

    /**
     * Get procesadores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProcesadores()
    {
        return $this->procesadores;
    }
}