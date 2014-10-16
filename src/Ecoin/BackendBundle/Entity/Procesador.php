<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Procesador
 */
class Procesador
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Pais", inversedBy="paises")
    * @ORM\JoinColumn(name="pais_id", referencedColumnName="id")
    */
    protected $pais; 

    /**
     * @ORM\ManyToMany(targetEntity="Ecoin\BackendBundle\Entity\Metodo", inversedBy="procesadores")
     * @ORM\JoinTable(name="procesadores_metodos")
     */
    private $metodos;

    /**
     * @ORM\ManyToMany(targetEntity="Ecoin\BackendBundle\Entity\Moneda", inversedBy="procesadores")
     * @ORM\JoinTable(name="procesadores_monedas")
     */
    private $monedas;

    /**
     * @ORM\ManyToMany(targetEntity="Ecoin\BackendBundle\Entity\Producto", inversedBy="procesadores")
     * @ORM\JoinTable(name="procesadores_productos_2p")
     */
    private $productos;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->metodos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->monedas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Procesador
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set pais
     *
     * @param \Ecoin\BackendBundle\Entity\Pais $pais
     * @return Procesador
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

    /**
     * Add metodos
     *
     * @param \Ecoin\BackendBundle\Entity\Metodo $metodos
     * @return Procesador
     */
    public function addMetodo(\Ecoin\BackendBundle\Entity\Metodo $metodos)
    {
        $this->metodos[] = $metodos;
    
        return $this;
    }

    /**
     * Remove metodos
     *
     * @param \Ecoin\BackendBundle\Entity\Metodo $metodos
     */
    public function removeMetodo(\Ecoin\BackendBundle\Entity\Metodo $metodos)
    {
        $this->metodos->removeElement($metodos);
    }

    /**
     * Get metodos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMetodos()
    {
        return $this->metodos;
    }

    /**
     * Add monedas
     *
     * @param \Ecoin\BackendBundle\Entity\Moneda $monedas
     * @return Procesador
     */
    public function addMoneda(\Ecoin\BackendBundle\Entity\Moneda $monedas)
    {
        $this->monedas[] = $monedas;
    
        return $this;
    }

    /**
     * Remove monedas
     *
     * @param \Ecoin\BackendBundle\Entity\Moneda $monedas
     */
    public function removeMoneda(\Ecoin\BackendBundle\Entity\Moneda $monedas)
    {
        $this->monedas->removeElement($monedas);
    }

    /**
     * Get monedas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMonedas()
    {
        return $this->monedas;
    }

    /**
     * Add productos
     *
     * @param \Ecoin\BackendBundle\Entity\Producto $productos
     * @return Procesador
     */
    public function addProducto(\Ecoin\BackendBundle\Entity\Producto $productos)
    {
        $this->productos[] = $productos;
    
        return $this;
    }

    /**
     * Remove productos
     *
     * @param \Ecoin\BackendBundle\Entity\Producto $productos
     */
    public function removeProducto(\Ecoin\BackendBundle\Entity\Producto $productos)
    {
        $this->productos->removeElement($productos);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductos()
    {
        return $this->productos;
    }
}