<?php

namespace Ecoin\FrontendBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Local
 */
class Local
{
    /**
     * @var integer
     */
    private $id;

    /**
     * Image path
     *
     * @var string
     *
     * @Assert\File(
     *     maxSize = "1M",     
     *     maxSizeMessage = "The maxmimum allowed file size is 1MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )     
     */
    protected $imagen;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $email;    

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Via", inversedBy="locales")
    * @ORM\JoinColumn(name="via_id", referencedColumnName="id")
    * @Assert\NotBlank(message="Seleccione la vía")  
    */
    protected $via;   

    /**
     * @var string
     */
    private $nombrevia;

    /**
     * @var string
     */
    private $numero;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Interior", inversedBy="locales")
    * @ORM\JoinColumn(name="interior_id", referencedColumnName="id")
    * @Assert\NotBlank(message="Seleccione el banco")  
    */
    protected $interior;   

    /**
     * @var string
     */
    private $numinterior;

    /**
     * @var string
     */
    private $referencia;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\FrontendBundle\Entity\Comercio", inversedBy="locales")
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
     * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Ciudad")
     * @ORM\JoinColumn(name="ciudad_id", referencedColumnName="id")
     * @Assert\Type("Ecoin\BackendBundle\Entity\Ciudad")
     * @Assert\NotBlank(message="Seleccione la ciudad")  
    */
    public $ciudad;

    /**
     * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Distrito")
     * @ORM\JoinColumn(name="distrito_id", referencedColumnName="id")
     * @Assert\Type("Ecoin\BackendBundle\Entity\Distrito")
     * @Assert\NotBlank(message="Seleccione el distrito")  
    */
    public $distrito;
    
    /**
     * @ORM\ManyToMany(targetEntity="Ecoin\FrontendBundle\Entity\Comerciohor", inversedBy="horarios")
     * @ORM\JoinTable(name="locales_horarios")
     */
    private $horarios;

    /**
     * @ORM\ManyToMany(targetEntity="Ecoin\FrontendBundle\Entity\Subcategoria", inversedBy="locales")
     * @ORM\JoinTable(name="locales_subcategorias")
     */
    private $subcategorias;
          
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->horarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subcategorias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set imagen
     *
     * @param string $imagen
     * @return Local
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Local
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
     * Set telefono
     *
     * @param string $telefono
     * @return Local
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Local
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nombrevia
     *
     * @param string $nombrevia
     * @return Local
     */
    public function setNombrevia($nombrevia)
    {
        $this->nombrevia = $nombrevia;

        return $this;
    }

    /**
     * Get nombrevia
     *
     * @return string 
     */
    public function getNombrevia()
    {
        return $this->nombrevia;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Local
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
     * Set numinterior
     *
     * @param string $numinterior
     * @return Local
     */
    public function setNuminterior($numinterior)
    {
        $this->numinterior = $numinterior;

        return $this;
    }

    /**
     * Get numinterior
     *
     * @return string 
     */
    public function getNuminterior()
    {
        return $this->numinterior;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     * @return Local
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string 
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set fchCreate
     *
     * @param \DateTime $fchCreate
     * @return Local
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
     * @return Local
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
     * Set ciudad
     *
     * @param \Ecoin\BackendBundle\Entity\Ciudad $ciudad
     * @return Local
     */
    public function setCiudad(\Ecoin\BackendBundle\Entity\Ciudad $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \Ecoin\BackendBundle\Entity\Ciudad 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set distrito
     *
     * @param \Ecoin\BackendBundle\Entity\Distrito $distrito
     * @return Local
     */
    public function setDistrito(\Ecoin\BackendBundle\Entity\Distrito $distrito = null)
    {
        $this->distrito = $distrito;

        return $this;
    }

    /**
     * Get distrito
     *
     * @return \Ecoin\BackendBundle\Entity\Distrito 
     */
    public function getDistrito()
    {
        return $this->distrito;
    }

    /**
     * Set comercio
     *
     * @param \Ecoin\FrontendBundle\Entity\Comercio $comercio
     * @return Local
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
     * Set via
     *
     * @param \Ecoin\BackendBundle\Entity\Via $via
     * @return Local
     */
    public function setVia(\Ecoin\BackendBundle\Entity\Via $via = null)
    {
        $this->via = $via;

        return $this;
    }

    /**
     * Get via
     *
     * @return \Ecoin\BackendBundle\Entity\Via 
     */
    public function getVia()
    {
        return $this->via;
    }

    /**
     * Set interior
     *
     * @param \Ecoin\BackendBundle\Entity\Interior $interior
     * @return Local
     */
    public function setInterior(\Ecoin\BackendBundle\Entity\Interior $interior = null)
    {
        $this->interior = $interior;

        return $this;
    }

    /**
     * Get interior
     *
     * @return \Ecoin\BackendBundle\Entity\Interior 
     */
    public function getInterior()
    {
        return $this->interior;
    }

    /**
     * Add horarios
     *
     * @param \Ecoin\FrontendBundle\Entity\Comerciohor $horarios
     * @return Local
     */
    public function addHorario(\Ecoin\FrontendBundle\Entity\Comerciohor $horarios)
    {
        $this->horarios[] = $horarios;

        return $this;
    }

    /**
     * Remove horarios
     *
     * @param \Ecoin\FrontendBundle\Entity\Comerciohor $horarios
     */
    public function removeHorario(\Ecoin\FrontendBundle\Entity\Comerciohor $horarios)
    {
        $this->horarios->removeElement($horarios);
    }

    /**
     * Get horarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHorarios()
    {
        return $this->horarios;
    }

    /**
     * Add subcategorias
     *
     * @param \Ecoin\BackendBundle\Entity\Subcategoria $subcategorias
     * @return Local
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
     * Sube la foto de la oferta copiándola en el directorio que se indica y
     * guardando en la entidad la ruta hasta la foto
     *
     * @param string $directorioDestino Ruta completa del directorio al que se sube la foto
     */
    public function UploadImage()
    {       
        if (null === $this->getImagen()) 
        {
            return;
        }

        $name = sha1(uniqid(mt_rand(), true));
        $filename= $name.'.'.$this->getImagen()->guessExtension();

        //$nombreArchivo = uniqid('foto-').'-1.'.$this->image->guessExtension();        

        $this->imagen->move($this->getWebPath(), $filename);

        $this->setImagen($filename);

        //$this->imagen = null;
    }
 
    public function getAbsolutePath()
    {
        return $this->getUploadRootDir().'/'.$this->id;
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->id;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'uploads/comercio';
    }

}