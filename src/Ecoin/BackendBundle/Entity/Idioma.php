<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Idioma
 */
class Idioma
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
     * @Assert\NotBlank(message="Ingrese el router")
     */
    private $router;


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
     * @return Idioma
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
     * Set router
     *
     * @param string $router
     * @return Idioma
     */
    public function setRouter($router)
    {
        $this->router = $router;
    
        return $this;
    }

    /**
     * Get router
     *
     * @return string 
     */
    public function getRouter()
    {
        return $this->router;
    }
}