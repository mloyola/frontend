<?php

namespace Ecoin\FrontendBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Usuario
 */
class Usuario implements UserInterface, \Serializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Ingrese su nombre")  
     */
    private $nombre;

    /**
     * @var string
     * @Assert\NotBlank(message="Ingrese su apellido")  
     */
    private $apellido;

     /**
     * @var string  
     * @Assert\Email(message = "El correo electrónico '{{ value }}' ingresado no tiene el formato correcto")
     * @Assert\NotBlank(message="Ingrese su correo electrónico")          
     */
    protected  $usuario;

    /**
     * @var string   
     * @Assert\NotBlank(message="Ingrese su contraseña")       
     */
    protected  $password;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Sexo", inversedBy="usuarios")
    * @ORM\JoinColumn(name="sexo_id", referencedColumnName="id")    
    * @Assert\NotBlank(message="Seleccione su sexo")  
    */
    protected $sexo;

    /**
      * @var string
      * @Assert\Image(maxSize = "200k")
     */
    protected $foto;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Pais")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id")
     * @Assert\Type("Ecoin\BackendBundle\Entity\Pais")
     * @Assert\NotBlank(message="Seleccione el país")  
    */
    protected $pais;

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
    */
    protected $distrito;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Idioma", inversedBy="usuarios")
    * @ORM\JoinColumn(name="idioma_id", referencedColumnName="id")    
    */
    protected $idioma;

     /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Tipodoc", inversedBy="usuarios")
    * @ORM\JoinColumn(name="tipodoc_id", referencedColumnName="id")
    */
    protected $tipodoc;

    /**
     * @var string     
     */
    private $numdoc;

    /**
     * @var \Date 
     */
    private $fchNac;

    /**
     * @var \DateTime
     */
    private $fchCreate;

    /**
     * @var \DateTime
     */
    private $fchUpdate;

    /**
     * @var boolean
     */
    private $marketing;

    /**
     * @var string     
     */
    private $estado;

     /**
      * @var string
     */
    protected $salt;    
       
    /**
     * @var \DateTime
     */
    private $fchActive;     
    
    /**
    * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->usuario;        
    }

    public function serialize()
    {
       return serialize($this->getId());
    }
 
    public function unserialize($data)
    {
        $this->id = unserialize($data);
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public  function eraseCredentials()
    {
        //Aqui se borran las cokkies y todo lo que se requiera
        //cuando el usuario se haya desauntenticado
        return false;
    }

    public function equals(userInterface $user)
    {
        return  $this->getUsername()== $user->getUsername();
    }   

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }


    public function getNombrecompleto()
    {
        return $this->getNombre().", ".$this->getApellido();
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
     * @return Usuario
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
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set numdoc
     *
     * @param string $numdoc
     * @return Usuario
     */
    public function setNumdoc($numdoc)
    {
        $this->numdoc = $numdoc;
    
        return $this;
    }

    /**
     * Get numdoc
     *
     * @return string 
     */
    public function getNumdoc()
    {
        return $this->numdoc;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     * @return Usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Set foto
     *
     * @param string $foto
     * @return Usuario
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    
        return $this;
    }

    /**
     * Get foto
     *
     * @return string 
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set fchNac
     *
     * @param \DateTime $fchNac
     * @return Usuario
     */
    public function setFchNac($fchNac)
    {
        $this->fchNac = $fchNac;
    
        return $this;
    }

    /**
     * Get fchNac
     *
     * @return \DateTime 
     */
    public function getFchNac()
    {
        return $this->fchNac;
    }

    /**
     * Set marketing
     *
     * @param boolean $marketing
     * @return Usuario
     */
    public function setMarketing($marketing)
    {
        $this->marketing = $marketing;
    
        return $this;
    }

    /**
     * Get marketing
     *
     * @return boolean 
     */
    public function getMarketing()
    {
        return $this->marketing;
    }

    /**
     * Set fchCreate
     *
     * @param \DateTime $fchCreate
     * @return Usuario
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
     * @return Usuario
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
     * Set estado
     *
     * @param string $estado
     * @return Usuario
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Set fchActive
     *
     * @param \DateTime $fchActive
     * @return Usuario
     */
    public function setFchActive($fchActive)
    {
        $this->fchActive = $fchActive;
    
        return $this;
    }

    /**
     * Get fchActive
     *
     * @return \DateTime 
     */
    public function getFchActive()
    {
        return $this->fchActive;
    }

    /**
     * Set pais
     *
     * @param \Ecoin\BackendBundle\Entity\Pais $pais
     * @return Usuario
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
     * Set ciudad
     *
     * @param \Ecoin\BackendBundle\Entity\Ciudad $ciudad
     * @return Usuario
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
     * @return Usuario
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
     * Set sexo
     *
     * @param \Ecoin\BackendBundle\Entity\Sexo $sexo
     * @return Usuario
     */
    public function setSexo(\Ecoin\BackendBundle\Entity\Sexo $sexo = null)
    {
        $this->sexo = $sexo;
    
        return $this;
    }

    /**
     * Get sexo
     *
     * @return \Ecoin\BackendBundle\Entity\Sexo 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set idioma
     *
     * @param \Ecoin\BackendBundle\Entity\Idioma $idioma
     * @return Usuario
     */
    public function setIdioma(\Ecoin\BackendBundle\Entity\Idioma $idioma = null)
    {
        $this->idioma = $idioma;
    
        return $this;
    }

    /**
     * Get idioma
     *
     * @return \Ecoin\BackendBundle\Entity\Idioma 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Set tipodoc
     *
     * @param \Ecoin\BackendBundle\Entity\Tipodoc $tipodoc
     * @return Usuario
     */
    public function setTipodoc(\Ecoin\BackendBundle\Entity\Tipodoc $tipodoc = null)
    {
        $this->tipodoc = $tipodoc;
    
        return $this;
    }

    /**
     * Get tipodoc
     *
     * @return \Ecoin\BackendBundle\Entity\Tipodoc 
     */
    public function getTipodoc()
    {
        return $this->tipodoc;
    }
}