<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subcategoria
 */
class Subcategoria
{
    /**
     * @var integer
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Categoria", inversedBy="subcategorias")
    * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
    */
    protected $categoria; 

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Opcionsubcategoria", inversedBy="subcategorias")
    * @ORM\JoinColumn(name="opcionsubcategoria_id", referencedColumnName="id")
    */
    protected $opcionsubcategoria; 

    /**
     * @ORM\ManyToMany(targetEntity="Ecoin\BackendBundle\Entity\Pais", inversedBy="subcategorias")
     * @ORM\JoinTable(name="subcategorias_paises")
     */
    private $paises;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->paises = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getOpcionsubcategoria()->getDescripcion();
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
     * Set categoria
     *
     * @param \Ecoin\BackendBundle\Entity\Categoria $categoria
     * @return Subcategoria
     */
    public function setCategoria(\Ecoin\BackendBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return \Ecoin\BackendBundle\Entity\Categoria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set opcionsubcategoria
     *
     * @param \Ecoin\BackendBundle\Entity\Opcionsubcategoria $opcionsubcategoria
     * @return Subcategoria
     */
    public function setOpcionsubcategoria(\Ecoin\BackendBundle\Entity\Opcionsubcategoria $opcionsubcategoria = null)
    {
        $this->opcionsubcategoria = $opcionsubcategoria;
    
        return $this;
    }

    /**
     * Get opcionsubcategoria
     *
     * @return \Ecoin\BackendBundle\Entity\Opcionsubcategoria 
     */
    public function getOpcionsubcategoria()
    {
        return $this->opcionsubcategoria;
    }

    /**
     * Add paises
     *
     * @param \Ecoin\BackendBundle\Entity\Pais $paises
     * @return Subcategoria
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