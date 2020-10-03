<?php

namespace ZeinebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Disponibilite
 *
 * @ORM\Table(name="disponibilite")
 * @ORM\Entity(repositoryClass="ZeinebBundle\Repository\DisponibiliteRepository")
 */
class Disponibilite
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
     * @ORM\Column(name="heurDebut", type="time")
     */
    private $heurDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heurFin", type="time")
     */
    private $heurFin;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=255)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="string", length=255)
     */
    private $lng;

    /**
     * @var string
     *
     * @ORM\Column(name="emailPro", type="string", length=255)
     */
    private $emailPro;

    /**
     * @var string
     *
     * @ORM\Column(name="numTelPro", type="string", length=255)
     */
    private $numTelPro;

    /**
     * @OneToOne(targetEntity="BaseBundle\Entity\User", mappedBy="disponibilite")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



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
     * Set heurDebut
     *
     * @param \DateTime $heurDebut
     *
     * @return Disponibilite
     */
    public function setHeurDebut($heurDebut)
    {
        $this->heurDebut = $heurDebut;

        return $this;
    }

    /**
     * Get heurDebut
     *
     * @return \DateTime
     */
    public function getHeurDebut()
    {
        return $this->heurDebut;
    }

    /**
     * Set heurFin
     *
     * @param \DateTime $heurFin
     *
     * @return Disponibilite
     */
    public function setHeurFin($heurFin)
    {
        $this->heurFin = $heurFin;

        return $this;
    }

    /**
     * Get heurFin
     *
     * @return \DateTime
     */
    public function getHeurFin()
    {
        return $this->heurFin;
    }

    /**
     * Set lat
     *
     * @param string $lat
     *
     * @return Disponibilite
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     *
     * @return Disponibilite
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set emailPro
     *
     * @param string $emailPro
     *
     * @return Disponibilite
     */
    public function setEmailPro($emailPro)
    {
        $this->emailPro = $emailPro;

        return $this;
    }

    /**
     * Get emailPro
     *
     * @return string
     */
    public function getEmailPro()
    {
        return $this->emailPro;
    }

    /**
     * Set numTelPro
     *
     * @param string $numTelPro
     *
     * @return Disponibilite
     */
    public function setNumTelPro($numTelPro)
    {
        $this->numTelPro = $numTelPro;

        return $this;
    }

    /**
     * Get numTelPro
     *
     * @return string
     */
    public function getNumTelPro()
    {
        return $this->numTelPro;
    }
}

