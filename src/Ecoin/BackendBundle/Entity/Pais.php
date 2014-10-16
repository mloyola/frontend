<?php

namespace Ecoin\BackendBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pais
 */
class Pais
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string     
     * @Assert\NotBlank(message="Ingrese el nombre")  
     */
    private $nombre;

    /**
     * @var string     
     * @Assert\NotBlank(message="Ingrese el código")
     */
    private $codigo;

    /**
     * @var string     
     * @Assert\NotBlank(message="Ingrese el identificador")
     */
    private $identificador;

    /**
     * @ORM\OneToMany(targetEntity="Ecoin\BackendBundle\Entity\Ciudad", mappedBy="pais")
     */
    protected $ciudades;   

    /**
     * @ORM\OneToMany(targetEntity="Ecoin\BackendBundle\Entity\Subcategoria", mappedBy="paises")
    */
    private $subcategorias;
    
    /**
     * @ORM\OneToMany(targetEntity="Ecoin\BackendBundle\Entity\Producto", mappedBy="paises")
    */
    private $productos;

    /**
     * @ORM\OneToMany(targetEntity="Ecoin\BackendBundle\Entity\Moneda", mappedBy="paises")
    */
    private $monedas;
    
    /**
     * @ORM\OneToMany(targetEntity="Ecoin\BackendBundle\Entity\Tipocta", mappedBy="paises")
    */
    private $tipocuentas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subcategorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->monedas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tipocuentas = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function __toString()
    {
        return $this->getNombre();
    }
    
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Pais
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
     * Set codigo
     *
     * @param string $codigo
     * @return Pais
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
     * Set identificador
     *
     * @param string $identificador
     * @return Pais
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
     * Add subcategorias
     *
     * @param \Ecoin\BackendBundle\Entity\Subcategoria $subcategorias
     * @return Pais
     */
    public function addSubcategoria(\Ecoin\BackendBundle\Entity\Subcategoria $subcategorias)
    {
        $this->subcategorias[] = $subcategorias;
    
        return $this;
    }

    /**
     * Remove subcategorias
     *
     * @param \Ecoin\BackendBundle\Entity\Subcategoria $subcategorias
     */
    public function removeSubcategoria(\Ecoin\BackendBundle\Entity\Subcategoria $subcategorias)
    {
        $this->subcategorias->removeElement($subcategorias);
    }

    /**
     * Get subcategorias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubcategorias()
    {
        return $this->subcategorias;
    }

    /**
     * Add productos
     *
     * @param \Ecoin\BackendBundle\Entity\Producto $productos
     * @return Pais
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

    /**
     * Add monedas
     *
     * @param \Ecoin\BackendBundle\Entity\Moneda $monedas
     * @return Pais
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
     * Add tipocuentas
     *
     * @param \Ecoin\BackendBundle\Entity\Tipocta $tipocuentas
     * @return Pais
     */
    public function addTipocuenta(\Ecoin\BackendBundle\Entity\Tipocta $tipocuentas)
    {
        $this->tipocuentas[] = $tipocuentas;
    
        return $this;
    }

    /**
     * Remove tipocuentas
     *
     * @param \Ecoin\BackendBundle\Entity\Tipocta $tipocuentas
     */
    public function removeTipocuenta(\Ecoin\BackendBundle\Entity\Tipocta $tipocuentas)
    {
        $this->tipocuentas->removeElement($tipocuentas);
    }

    /**
     * Get tipocuentas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTipocuentas()
    {
        return $this->tipocuentas;
    }
}