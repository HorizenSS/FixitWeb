<?php

namespace BaseBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Model\UserNotificationInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $photo;



    /**
     * @ORM\OneToMany(targetEntity="BaseBundle\Entity\User",mappedBy="user",cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */

    private $adress;

    /**
     * @var Notification
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="user", orphanRemoval=true ,cascade={"persist"})
     */
    protected $notifications;

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
     * @ORM\OneToOne(targetEntity="ZeinebBundle\Entity\Disponibilite" , inversedBy="User")
     * @ORM\JoinColumn(name="disponibilite_id", referencedColumnName="id" ,onDelete="SET NULL")
     */
    private $disponibilite;

    /**
     * @ORM\OneToOne(targetEntity="ZeinebBundle\Entity\Convention" , inversedBy="User")
     * @ORM\JoinColumn(name="convention_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $convention;

    public function __construct()
    {
        parent::__construct();
        $this->notifications = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * {@inheritdoc}
     */
    public function addNotification($notification)
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeNotification($notification)
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        $this->getId();
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }





    /**
     * Get adress
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdress()
    {
        return $this->adress;
    }
}
