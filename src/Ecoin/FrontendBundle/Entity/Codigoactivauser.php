<?php

namespace Ecoin\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Codigoactivauser
 */
class Codigoactivauser
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
    * @ORM\ManyToOne(targetEntity="Ecoin\FrontendBundle\Entity\Usuario", inversedBy="codigoactivausers")
    * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
    */
    protected $usuario;

    /**
     * @var \DateTime
     */
    private $fchCreate;


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
     * @return Codigoactivauser
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
     * Set fchCreate
     *
     * @param \DateTime $fchCreate
     * @return Codigoactivauser
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
}
