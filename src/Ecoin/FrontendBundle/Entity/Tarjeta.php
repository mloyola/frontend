<?php

namespace Ecoin\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tarjeta
 */
class Tarjeta
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var date
     */
    private $expdate;

    /**
     * @var string
     */
    private $securitycode;

    /**
     * @var string
     */
    private $holdername;
         
    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Producto", inversedBy="tarjetas")
    * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
    */
    protected $producto;    

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\FrontendBundle\Entity\Usuario", inversedBy="tarjetas")
    * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
    */
    protected $usuario;            


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
     * Set numero
     *
     * @param string $numero
     * @return Tarjeta
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set expdate
     *
     * @param \DateTime $expdate
     * @return Tarjeta
     */
    public function setExpdate($expdate)
    {
        $this->expdate = $expdate;

        return $this;
    }

    /**
     * Get expdate
     *
     * @return \DateTime 
     */
    public function getExpdate()
    {
        return $this->expdate;
    }

    /**
     * Set securitycode
     *
     * @param string $securitycode
     * @return Tarjeta
     */
    public function setSecuritycode($securitycode)
    {
        $this->securitycode = $securitycode;

        return $this;
    }

    /**
     * Get securitycode
     *
     * @return string 
     */
    public function getSecuritycode()
    {
        return $this->securitycode;
    }

    /**
     * Set holdername
     *
     * @param string $holdername
     * @return Tarjeta
     */
    public function setHoldername($holdername)
    {
        $this->holdername = $holdername;

        return $this;
    }

    /**
     * Get holdername
     *
     * @return string 
     */
    public function getHoldername()
    {
        return $this->holdername;
    }

    /**
     * Set producto
     *
     * @param \Ecoin\BackendBundle\Entity\Producto $producto
     * @return Tarjeta
     */
    public function setProducto(\Ecoin\BackendBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \Ecoin\BackendBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set usuario
     *
     * @param \Ecoin\FrontendBundle\Entity\Usuario $usuario
     * @return Tarjeta
     */
    public function setUsuario(\Ecoin\FrontendBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Ecoin\FrontendBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
