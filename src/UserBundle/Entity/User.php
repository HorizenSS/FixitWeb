<?php
// src/AppBundle/Entity/User.php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="zeineb")
 * @Notifiable(name="User")
 */

class User extends BaseUser implements NotifiableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;




    /**
     * @OneToOne(targetEntity="ZeinebBundle\Entity\Disponibilite" , inversedBy="user")
     * @JoinColumn(name="disponibilite_id", referencedColumnName="id" ,onDelete="SET NULL")
     */
    private $disponibilite;

    /**
     * @OneToOne(targetEntity="ZeinebBundle\Entity\Convention" , inversedBy="user")
     * @JoinColumn(name="convention_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $convention;



    public function __construct()
    {
        parent::__construct();
        // your own logic

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * @param mixed $disponibilite
     */
    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;
    }

    /**
     * @return mixed
     */
    public function getConvention()
    {
        return $this->convention;
    }

    /**
     * @param mixed $convention
     */
    public function setConvention($convention)
    {
        $this->convention = $convention;
    }


}




