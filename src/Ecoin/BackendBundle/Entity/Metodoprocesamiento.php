<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Metodoprocesamiento
 */
class Metodoprocesamiento
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
    private $acquirer;


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
     * @return Metodoprocesamiento
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
     * Set acquirer
     *
     * @param string $acquirer
     * @return Metodoprocesamiento
     */
    public function setAcquirer($acquirer)
    {
        $this->acquirer = $acquirer;
    
        return $this;
    }

    /**
     * Get acquirer
     *
     * @return string 
     */
    public function getAcquirer()
    {
        return $this->acquirer;
    }
}
