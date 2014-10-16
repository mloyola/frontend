<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moneda
 */
class Moneda
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
    private $descripcion;

    /**
     * @var string
     */
    private $sigla;

    /**
     * @ORM\OneToMany(targetEntity="Ecoin\BackendBundle\Entity\Procesador", mappedBy="monedas")
    */
    private $procesadores;

    /**
     * @ORM\ManyToMany(targetEntity="Ecoin\BackendBundle\Entity\Pais", inversedBy="monedas")
     * @ORM\JoinTable(name="monedas_paises")
     */
    private $paises;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->procesadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->paises = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set codigo
     *
     * @param string $codigo
     * @return Moneda
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Moneda
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
     * Set sigla
     *
     * @param string $sigla
     * @return Moneda
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string 
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Add procesadores
     *
     * @param \Ecoin\BackendBundle\Entity\Procesador $procesadores
     * @return Moneda
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

    /**
     * Add paises
     *
     * @param \Ecoin\BackendBundle\Entity\Pais $paises
     * @return Moneda
     */
    public function addPaise(\Ecoin\BackendBundle\Entity\Pais $paises)
    {
        $this->paises[] = $paises;
    
        return $this;
    }

    /**
     * Remove paises
     *
     * @param \Ecoin\BackendBundle\Entity\Pais $paises
     */
    public function removePaise(\Ecoin\BackendBundle\Entity\Pais $paises)
    {
        $this->paises->removeElement($paises);
    }

    /**
     * Get paises
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPaises()
    {
        return $this->paises;
    }
}