<?php

namespace Ecoin\FrontendBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Comercio
 */

/**
 * @ORM\Entity
 * @UniqueEntity(fields="usuario",message="Actualmente existe un usuario registrado con el correo electrónico ingresado")
 */
class Comercio implements UserInterface, \Serializable
{
    /**
     * @var integer
     */
    private $id;

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
     * @var string
     * @Assert\NotBlank(message="Ingrese el nombre comercial o de la empresa")  
     */
    private $nombre; 

    /**
     * @var string
     * @Assert\NotBlank(message="Ingrese el nombre de la razón social")  
     */
    private $razonsocial;

    /**
      * @var string
      * @Assert\Image(maxSize = "200k")
     */
    protected $logo;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Categoria", inversedBy="comercios")
    * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
    * @Assert\NotBlank(message="Seleccione la categoría")  
    */
    protected $categoria;

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Pais", inversedBy="comercios")
    * @ORM\JoinColumn(name="pais_id", referencedColumnName="id")
    * @Assert\NotBlank(message="Seleccione el país")  
    */
    protected $pais;   

    /**
    * @ORM\ManyToOne(targetEntity="Ecoin\BackendBundle\Entity\Idioma", inversedBy="comercios")
    * @ORM\JoinColumn(name="idioma_id", referencedColumnName="id")    
    */
    protected $idioma; 

    /**
     * @var string          
     */
    private $ruc;   

    /**
     * @var string     
     */
    private $contacto;   

    /**
     * @var string     
     */
    private $telefono;

    /**
     * @var string     
     */
    private $movil;

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
     * @var \DateTime
     */
    private $fchActive;

    /**
     * @var string     
     */
    private $estado;

    /**
     * @var string     
     */
    private $estadocategorias;

    /**
     * @var string     
     */
    private $estadolocales;

    /**
     * @var string     
     */
    private $estadocuentas;

     /**
      * @var string
     */
    protected $salt;               

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
        return array('ROLE_NEGO');
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
     * Set usuario
     *
     * @param string $usuario
     * @return Comercio
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
     * @return Comercio
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Comercio
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
     * Set razonsocial
     *
     * @param string $razonsocial
     * @return Comercio
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;
    
        return $this;
    }

    /**
     * Get razonsocial
     *
     * @return string 
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Comercio
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set ruc
     *
     * @param string $ruc
     * @return Comercio
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    
        return $this;
    }

    /**
     * Get ruc
     *
     * @return string 
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * Set contacto
     *
     * @param string $contacto
     * @return Comercio
     */
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;
    
        return $this;
    }

    /**
     * Get contacto
     *
     * @return string 
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Comercio
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
     * Set movil
     *
     * @param string $movil
     * @return Comercio
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;
    
        return $this;
    }

    /**
     * Get movil
     *
     * @return string 
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Set marketing
     *
     * @param boolean $marketing
     * @return Comercio
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
     * @return Comercio
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
     * @return Comercio
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
     * Set fchActive
     *
     * @param \DateTime $fchActive
     * @return Comercio
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
     * Set estado
     *
     * @param string $estado
     * @return Comercio
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
     * Set estadocategorias
     *
     * @param string $estadocategorias
     * @return Comercio
     */
    public function setEstadocategorias($estadocategorias)
    {
        $this->estadocategorias = $estadocategorias;
    
        return $this;
    }

    /**
     * Get estadocategorias
     *
     * @return string 
     */
    public function getEstadocategorias()
    {
        return $this->estadocategorias;
    }

    /**
     * Set estadolocales
     *
     * @param string $estadolocales
     * @return Comercio
     */
    public function setEstadolocales($estadolocales)
    {
        $this->estadolocales = $estadolocales;
    
        return $this;
    }

    /**
     * Get estadolocales
     *
     * @return string 
     */
    public function getEstadolocales()
    {
        return $this->estadolocales;
    }

    /**
     * Set estadocuentas
     *
     * @param string $estadocuentas
     * @return Comercio
     */
    public function setEstadocuentas($estadocuentas)
    {
        $this->estadocuentas = $estadocuentas;
    
        return $this;
    }

    /**
     * Get estadocuentas
     *
     * @return string 
     */
    public function getEstadocuentas()
    {
        return $this->estadocuentas;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Comercio
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Set pais
     *
     * @param \Ecoin\BackendBundle\Entity\Pais $pais
     * @return Comercio
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
     * Set categoria
     *
     * @param \Ecoin\BackendBundle\Entity\Categoria $categoria
     * @return Comercio
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
     * Set idioma
     *
     * @param \Ecoin\BackendBundle\Entity\Idioma $idioma
     * @return Comercio
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
}