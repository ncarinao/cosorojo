<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Rubro
 *
 * @ORM\Table(name="rubro")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RubroRepository")
 */
class Rubro
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
     * @ORM\Column(name="rub_nombre", type="string", length=255)
     */
    private $rubNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="rub_foto", type="string", length=255)
     */
    private $rubFoto;

    /**
     * @var string
     *
     * @ORM\Column(name="rub_direccion", type="string", length=255)
     */
    private $rubDireccion;

    /**
     * @var string
     *
     * @ORM\Column(name="rub_slug", type="string", length=255, unique=true)
     */
    private $rubSlug;


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
     * Set rubNombre
     *
     * @param string $rubNombre
     *
     * @return Rubro
     */
    public function setRubNombre($rubNombre)
    {
        $this->rubNombre = $rubNombre;

        return $this;
    }

    /**
     * Get rubNombre
     *
     * @return string
     */
    public function getRubNombre()
    {
        return $this->rubNombre;
    }

    /**
     * Set rubFoto
     *
     * @param string $rubFoto
     *
     * @return Rubro
     */
    public function setRubFoto($rubFoto)
    {
        $this->rubFoto = $rubFoto;

        return $this;
    }

    /**
     * Get rubFoto
     *
     * @return string
     */
    public function getRubFoto()
    {
        return $this->rubFoto;
    }

    /**
     * Set rubDireccion
     *
     * @param string $rubDireccion
     *
     * @return Rubro
     */
    public function setRubDireccion($rubDireccion)
    {
        $this->rubDireccion = $rubDireccion;

        return $this;
    }

    /**
     * Get rubDireccion
     *
     * @return string
     */
    public function getRubDireccion()
    {
        return $this->rubDireccion;
    }

    /**
     * Set rubSlug
     *
     * @param string $rubSlug
     *
     * @return Rubro
     */
    public function setRubSlug($rubSlug)
    {
        $this->rubSlug = $rubSlug;

        return $this;
    }

    /**
     * Get rubSlug
     *
     * @return string
     */
    public function getRubSlug()
    {
        return $this->rubSlug;
    }
//----------------------------------------------------------------------------------------
    /**
     * @ORM\OneToMany(targetEntity="Negocio", mappedBy="Rubro")
     * @ORM\OneToMany(targetEntity="Servicio", mappedBy="Rubro")
     */
    private $negocios;
    private $servicios;

    public function __construct()
    {
        $this->negocios = new ArrayCollection();
        $this->servicios = new ArrayCollection();
    }


    /**
     * Add negocio
     *
     * @param \AppBundle\Entity\Negocio $negocio
     *
     * @return Rubro
     */
    public function addNegocio(\AppBundle\Entity\Negocio $negocio)
    {
        $this->negocios[] = $negocio;

        return $this;
    }

    /**
     * Remove negocio
     *
     * @param \AppBundle\Entity\Negocio $negocio
     */
    public function removeNegocio(\AppBundle\Entity\Negocio $negocio)
    {
        $this->negocios->removeElement($negocio);
    }

    /**
     * Get negocios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNegocios()
    {
        return $this->negocios;
    }


    public function __toString(){
        return (string) $this->id." ".$this->rubNombre;
    }
}
