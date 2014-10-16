<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Banco
 */
class Banco
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $identificador;

    /**
     * @var string
     */
    private $descripcion;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Pais", inversedBy="bancos")
    * @ORM\JoinColumn(name="pais_id", referencedColumnName="id")
    */
    protected $pais;     

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getDescripcion();
    }

    /**
     * Set identificador
     *
     * @param string $identificador
     * @return Banco
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;
    
        return $this;
    }

    /**
     * Get identificador
     *
     * @return string 
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Banco
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
     * Set pais
     *
     * @param \Ecoin\BackendBundle\Entity\Pais $pais
     * @return Banco
     */
    public function setPais(\Ecoin\BackendBundle\Entity\Pais $pais = null)
    {
        $this->pais = $pais;
    
        return $this;
    }

    /**
     * Get pais
     *
     * @return \Ecoin\BackendBundle\Entity\Pais 
     */
    public function getPais()
    {
        return $this->pais;
    }
}