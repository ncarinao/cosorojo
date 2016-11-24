<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servicio
 *
 * @ORM\Table(name="servicio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicioRepository")
 */
class Servicio
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
     * @ORM\Column(name="ser_nombre", type="string", length=255)
     */
    private $serNombre;


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
     * Set serNombre
     *
     * @param string $serNombre
     *
     * @return Servicio
     */
    public function setSerNombre($serNombre)
    {
        $this->serNombre = $serNombre;

        return $this;
    }

    /**
     * Get serNombre
     *
     * @return string
     */
    public function getSerNombre()
    {
        return $this->serNombre;
    }
//    ---------------------------------------------------------------------------------------------------------

    /**
     * @ORM\ManyToOne(targetEntity="Rubro", inversedBy="servicios")
     * @ORM\JoinColumn(name="id_rubro", referencedColumnName="id")
     */
    private $rubro;    

    /**
     * Set rubro
     *
     * @param \AppBundle\Entity\Rubro $rubro
     *
     * @return Servicio
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


    public function __toString(){
        return (string) $this->id." ".$this->serNombre;
    }
}
