<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Disponibilidad
 *
 * @ORM\Table(name="disponibilidad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DisponibilidadRepository")
 */
class Disponibilidad
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
     * @var \DateTime
     *
     * @ORM\Column(name="dis_inicio_am", type="time")
     */
    private $disInicioAm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dis_fin_am", type="time")
     */
    private $disFinAm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dis_inicio_pm", type="time")
     */
    private $disInicioPm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dis_fin_pm", type="time")
     */
    private $disFinPm;

    /**
     * @var string
     *
     * @ORM\Column(name="dis_dia", type="string", length=255)
     */
    private $disDia;


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
     * Set disInicioAm
     *
     * @param \DateTime $disInicioAm
     *
     * @return Disponibilidad
     */
    public function setDisInicioAm($disInicioAm)
    {
        $this->disInicioAm = $disInicioAm;

        return $this;
    }

    /**
     * Get disInicioAm
     *
     * @return \DateTime
     */
    public function getDisInicioAm()
    {
        return $this->disInicioAm;
    }

    /**
     * Set disFinAm
     *
     * @param \DateTime $disFinAm
     *
     * @return Disponibilidad
     */
    public function setDisFinAm($disFinAm)
    {
        $this->disFinAm = $disFinAm;

        return $this;
    }

    /**
     * Get disFinAm
     *
     * @return \DateTime
     */
    public function getDisFinAm()
    {
        return $this->disFinAm;
    }

    /**
     * Set disInicioPm
     *
     * @param \DateTime $disInicioPm
     *
     * @return Disponibilidad
     */
    public function setDisInicioPm($disInicioPm)
    {
        $this->disInicioPm = $disInicioPm;

        return $this;
    }

    /**
     * Get disInicioPm
     *
     * @return \DateTime
     */
    public function getDisInicioPm()
    {
        return $this->disInicioPm;
    }

    /**
     * Set disFinPm
     *
     * @param \DateTime $disFinPm
     *
     * @return Disponibilidad
     */
    public function setDisFinPm($disFinPm)
    {
        $this->disFinPm = $disFinPm;

        return $this;
    }

    /**
     * Get disFinPm
     *
     * @return \DateTime
     */
    public function getDisFinPm()
    {
        return $this->disFinPm;
    }

    /**
     * Set disDia
     *
     * @param string $disDia
     *
     * @return Disponibilidad
     */
    public function setDisDia($disDia)
    {
        $this->disDia = $disDia;

        return $this;
    }

    /**
     * Get disDia
     *
     * @return string
     */
    public function getDisDia()
    {
        return $this->disDia;
    }
//---------------------------------------------------------------------
    /**
     * @ORM\ManyToOne(targetEntity="Opcion", inversedBy="disponibilidades")
     * @ORM\JoinColumn(name="id_opcion", referencedColumnName="id")
     */
    private $opcion;

    /**
     * Set opcion
     *
     * @param \AppBundle\Entity\Opcion $opcion
     *
     * @return Disponibilidad
     */
    public function setOpcion(\AppBundle\Entity\Opcion $opcion = null)
    {
        $this->opcion = $opcion;

        return $this;
    }

    /**
     * Get opcion
     *
     * @return \AppBundle\Entity\Opcion
     */
    public function getOpcion()
    {
        return $this->opcion;
    }

    public function __toString(){
        return (string) $this->id." ".$this->disDia;
    }
}
