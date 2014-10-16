<?php

namespace Ecoin\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comerciohor
 */
class Comerciohor
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $apertura;

    /**
     * @var \DateTime
     */
    private $cierre;

    /**
     * @ORM\ManyToMany(targetEntity="Ecoin\BackendBundle\Entity\Diasatencion", inversedBy="comerciohrs")
     * @ORM\JoinTable(name="comerciohors_dias")
     */
    private $dias;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\FrontendBundle\Entity\Comercio", inversedBy="comerciohrs")
    * @ORM\JoinColumn(name="comercio_id", referencedColumnName="id")
    */
    protected $comercio;            

    /**
     * @var \DateTime
     */
    private $fchCreate;

    /**
     * @var \DateTime
     */
    private $fchUpdate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getDescripcion().' '.$this->getApertura()->format('H:i').' - '.$this->getCierre()->format('H:i');
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
     * @return Comerciohor
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
     * Set apertura
     *
     * @param \DateTime $apertura
     * @return Comerciohor
     */
    public function setApertura($apertura)
    {
        $this->apertura = $apertura;
    
        return $this;
    }

    /**
     * Get apertura
     *
     * @return \DateTime 
     */
    public function getApertura()
    {
        return $this->apertura;
    }

    /**
     * Set cierre
     *
     * @param \DateTime $cierre
     * @return Comerciohor
     */
    public function setCierre($cierre)
    {
        $this->cierre = $cierre;
    
        return $this;
    }

    /**
     * Get cierre
     *
     * @return \DateTime 
     */
    public function getCierre()
    {
        return $this->cierre;
    }

    /**
     * Set fchCreate
     *
     * @param \DateTime $fchCreate
     * @return Comerciohor
     */
    public function setFchCreate($fchCreate)
    {
        $this->fchCreate = $fchCreate;
    
        return $this;
    }

    /**
     * Get fchCreate
     *
     * @return \DateTime 
     */
    public function getFchCreate()
    {
        return $this->fchCreate;
    }

    /**
     * Set fchUpdate
     *
     * @param \DateTime $fchUpdate
     * @return Comerciohor
     */
    public function setFchUpdate($fchUpdate)
    {
        $this->fchUpdate = $fchUpdate;
    
        return $this;
    }

    /**
     * Get fchUpdate
     *
     * @return \DateTime 
     */
    public function getFchUpdate()
    {
        return $this->fchUpdate;
    }

    /**
     * Set comercio
     *
     * @param \Ecoin\FrontendBundle\Entity\Comercio $comercio
     * @return Comerciohor
     */
    public function setComercio(\Ecoin\FrontendBundle\Entity\Comercio $comercio = null)
    {
        $this->comercio = $comercio;
    
        return $this;
    }

    /**
     * Get comercio
     *
     * @return \Ecoin\FrontendBundle\Entity\Comercio 
     */
    public function getComercio()
    {
        return $this->comercio;
    }

    /**
     * Add dias
     *
     * @param \Ecoin\BackendBundle\Entity\Diasatencion $dias
     * @return Comerciohor
     */
    public function addDia(\Ecoin\BackendBundle\Entity\Diasatencion $dias)
    {
        $this->dias[] = $dias;
    
        return $this;
    }

    /**
     * Remove dias
     *
     * @param \Ecoin\BackendBundle\Entity\Diasatencion $dias
     */
    public function removeDia(\Ecoin\BackendBundle\Entity\Diasatencion $dias)
    {
        $this->dias->removeElement($dias);
    }

    /**
     * Get dias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDias()
    {
        return $this->dias;
    }
}