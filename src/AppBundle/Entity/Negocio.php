<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Negocio
 *
 * @ORM\Table(name="negocio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NegocioRepository")
 */
class Negocio
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="neg_nombre", type="string", length=255)
     */
    private $negNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="neg_direccion", type="string", length=255)
     */
    private $negDireccion;

    /**
     * @var int
     *
     * @ORM\Column(name="neg_telefono", type="integer")
     */
    private $negTelefono;

    /**
     * @var string
     *
     * @ORM\Column(name="neg_foto1", type="string", length=255)
     */
    private $negFoto1;

    /**
     * @var string
     *
     * @ORM\Column(name="neg_foto2", type="string", length=255)
     */
    private $negFoto2;

    /**
     * @var string
     *
     * @ORM\Column(name="neg_url", type="string", length=255)
     */
    private $negUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="neg_descripcion", type="text")
     */
    private $negDescripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="neg_slug", type="string", length=255, unique=true)
     */
    private $negSlug;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set negNombre
     *
     * @param string $negNombre
     *
     * @return Negocio
     */
    public function setNegNombre($negNombre)
    {
        $this->negNombre = $negNombre;

        return $this;
    }

    /**
     * Get negNombre
     *
     * @return string
     */
    public function getNegNombre()
    {
        return $this->negNombre;
    }

    /**
     * Set negDireccion
     *
     * @param string $negDireccion
     *
     * @return Negocio
     */
    public function setNegDireccion($negDireccion)
    {
        $this->negDireccion = $negDireccion;

        return $this;
    }

    /**
     * Get negDireccion
     *
     * @return string
     */
    public function getNegDireccion()
    {
        return $this->negDireccion;
    }

    /**
     * Set negTelefono
     *
     * @param integer $negTelefono
     *
     * @return Negocio
     */
    public function setNegTelefono($negTelefono)
    {
        $this->negTelefono = $negTelefono;

        return $this;
    }

    /**
     * Get negTelefono
     *
     * @return int
     */
    public function getNegTelefono()
    {
        return $this->negTelefono;
    }

    /**
     * Set negFoto1
     *
     * @param string $negFoto1
     *
     * @return Negocio
     */
    public function setNegFoto1($negFoto1)
    {
        $this->negFoto1 = $negFoto1;

        return $this;
    }

    /**
     * Get negFoto1
     *
     * @return string
     */
    public function getNegFoto1()
    {
        return $this->negFoto1;
    }

    /**
     * Set negFoto2
     *
     * @param string $negFoto2
     *
     * @return Negocio
     */
    public function setNegFoto2($negFoto2)
    {
        $this->negFoto2 = $negFoto2;

        return $this;
    }

    /**
     * Get negFoto2
     *
     * @return string
     */
    public function getNegFoto2()
    {
        return $this->negFoto2;
    }

    /**
     * Set negUrl
     *
     * @param string $negUrl
     *
     * @return Negocio
     */
    public function setNegUrl($negUrl)
    {
        $this->negUrl = $negUrl;

        return $this;
    }

    /**
     * Get negUrl
     *
     * @return string
     */
    public function getNegUrl()
    {
        return $this->negUrl;
    }

    /**
     * Set negDescripcion
     *
     * @param string $negDescripcion
     *
     * @return Negocio
     */
    public function setNegDescripcion($negDescripcion)
    {
        $this->negDescripcion = $negDescripcion;

        return $this;
    }

    /**
     * Get negDescripcion
     *
     * @return string
     */
    public function getNegDescripcion()
    {
        return $this->negDescripcion;
    }

    /**
     * Set negSlug
     *
     * @param string $negSlug
     *
     * @return Negocio
     */
    public function setNegSlug($negSlug)
    {
        $this->negSlug = $negSlug;

        return $this;
    }

    /**
     * Get negSlug
     *
     * @return string
     */
    public function getNegSlug()
    {
        return $this->negSlug;
    }
//    ---------------------------------------------------------------------------------------------------------

    /**
     * @ORM\ManyToOne(targetEntity="Rubro", inversedBy="negocios")
     * @ORM\JoinColumn(name="id_rubro", referencedColumnName="id")
     */
    private $rubro;

    /**
     * Set rubro
     *
     * @param \AppBundle\Entity\Rubro $rubro
     *
     * @return Negocio
     */
    public function setRubro(\AppBundle\Entity\Rubro $rubro = null)
    {
        $this->rubro = $rubro;

        return $this;
    }

    /**
     * Get rubro
     *
     * @return \AppBundle\Entity\Rubro
     */
    public function getRubro()
    {
        return $this->rubro;
    }
//----------------------------------------------------------------------------------------
    /**
     * @ORM\OneToMany(targetEntity="Opcion", mappedBy="Negocio")
     * @ORM\OneToMany(targetEntity="Personal", mappedBy="Negocio")
     */
    private $opciones;
    private $personal;

    public function __construct()
    {
        $this->opciones = new ArrayCollection();
        $this->personal = new ArrayCollection();
    }

    /**
     * Add opcione
     *
     * @param \AppBundle\Entity\Opcion $opcione
     *
     * @return Negocio
     */
    public function addOpcione(\AppBundle\Entity\Opcion $opcione)
    {
        $this->opciones[] = $opcione;

        return $this;
    }

    /**
     * Remove opcione
     *
     * @param \AppBundle\Entity\Opcion $opcione
     */
    public function removeOpcione(\AppBundle\Entity\Opcion $opcione)
    {
        $this->opciones->removeElement($opcione);
    }

    /**
     * Get opciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpciones()
    {
        return $this->opciones;
    }
    
//---------------------------------------------------------
    public function __toString(){
        return (string) $this->id;
    }
        
}
