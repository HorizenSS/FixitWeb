<?php

namespace ZeinebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Convention
 *
 * @ORM\Table(name="convention")
 * @ORM\Entity(repositoryClass="ZeinebBundle\Repository\ConventionRepository")
 */
class Convention
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
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="img_url", type="string", length=255)
     */
    private $imgUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_societe", type="string", length=255)
     */
    private $nomSoc;

    /**
     * @OneToOne(targetEntity="BaseBundle\Entity\User", mappedBy="convention")
     */
    private $user;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Convention
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Convention
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Convention
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * @param string $imgUrl
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return string
     */
    public function getNomSoc()
    {
        return $this->nomSoc;
    }

    /**
     * @param string $nomSoc
     */
    public function setNomSoc($nomSoc)
    {
        $this->nomSoc = $nomSoc;
    }

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


}

