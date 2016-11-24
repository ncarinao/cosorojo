<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="User")
     * @ORM\OneToMany(targetEntity="Personal", mappedBy="User")
     */
    protected $id;
    private $reservas;
    private $peronal;
    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->reservas = new ArrayCollection();
        $this->personal = new ArrayCollection();
    }


    public function __toString(){
        return (string) $this->id." ".$this->username;
    }

}
