<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personal
 *
 * @ORM\Table(name="personal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonalRepository")
 */
class Personal
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
//----------------------------------------------------------------------------------

    /**
     * @ORM\ManyToOne(targetEntity="Negocio", inversedBy="personal")
     * @ORM\JoinColumn(name="id_negocio", referencedColumnName="id")
     */
    private $negocio;
//----------------------------------------------------------------------------------

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="personal")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * Set negocio
     *
     * @param \AppBundle\Entity\Negocio $negocio
     *
     * @return Personal
     */
    public function setNegocio(\AppBundle\Entity\Negocio $negocio = null)
    {
        $this->negocio = $negocio;

        return $this;
    }

    /**
     * Get negocio
     *
     * @return \AppBundle\Entity\Negocio
     */
    public function getNegocio()
    {
        return $this->negocio;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Personal
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString(){
        return (string) $this->id;
    }
}
