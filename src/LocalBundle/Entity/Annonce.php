<?php

namespace LocalBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;
/**
 * Annonce
 *
 * @ORM\Table(name="annonce", indexes={@ORM\Index(name="id_prop", columns={"id_prop"}), @ORM\Index(name="id_local", columns={"id_local"})})
 * @ORM\Entity(repositoryClass="LocalBundle\Repository\AnnonceRepository")
 * @Notifiable(name="annonce")
*/
class Annonce implements NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 4,
     * max = 30,
     * minMessage = "Le titre doit etre composé d'aumoins {{ limit }} characteres ",
     * maxMessage = "Le titre ne doit pas dépasser {{ limit }} characteres. Ajouter plutot une déscription!"
     * )
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     *  message="veuillez inserer quelque chose"
     */
    private $description;

    /*
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }


    /**
     * @var \DateTime
     * @Assert\Date()
     * @Assert\GreaterThan("today")
     * message="choisir ue date superieure a la date courante"
     * @ORM\Column(name="startdate", type="date", nullable=true)
     */
    private $startdate;

    /**
     * @var \DateTime
     *@Assert\Date()
     *@Assert\Expression(
     *     "this.getStartdate() < this.getEnddate()",
     *     message="la date d'epiration doit etre superieur a la date de debut"
     * )
     * @ORM\Column(name="enddate", type="date", nullable=true)
     */
    private $enddate;

    /**
     * @var float
     * @Assert\Range(
     * min = 0,
     * max = 1000000)
     * minMessage="le prix ne doit pas etre negatif"
     * maxMessage="soyer raisonable"
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=50, nullable=false)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insertdate", type="date", nullable=true)
     */
    private $insertdate;

    /**
     * Many Features have One Modele.
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\User")
     * @ORM\JoinColumn(name="id_prop", referencedColumnName="id")
     */
    private $id_prop;


    /**
     * Many Features have One Modele.
     * @ORM\ManyToOne(targetEntity="LocalBundle\Entity\Local")
     * @ORM\JoinColumn(name="id_local", referencedColumnName="id_local", onDelete="CASCADE")
     */
    private $id_local;

    /**
     *
     *
     * @ORM\Column(type="integer",length=255,nullable=true,options={"default" : 0})
     */
    private $nbr_signal;

    /**
     * @return bool
     */
    public function isApprouve()
    {
        return $this->approuve;
    }

    /**
     * @param bool $approuve
     */
    public function setApprouve($approuve)
    {
        $this->approuve = $approuve;
    }

    /**
     * @var Boolean
     *
     * @ORM\Column(name="approuve", type="boolean", options={"default":"0"})
     */
    private $approuve=false;

    /**
     * @return mixed
     */
    public function getNbrSignal()
    {
        return $this->nbr_signal;
    }

    /**
     * @param mixed $nbr_signal
     */
    public function setNbrSignal($nbr_signal)
    {
        $this->nbr_signal = $nbr_signal;
    }





    /**
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * @param \DateTime $startdate
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
    }

    /**
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * @param \DateTime $enddate
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getIdProp()
    {
        return $this->id_prop;
    }

    /**
     * @param mixed $id_prop
     */
    public function setIdProp($id_prop)
    {
        $this->id_prop = $id_prop;
    }

    /**
     * @return mixed
     */
    public function getIdLocal()
    {
        return $this->id_local;
    }

    /**
     * @param mixed $id_local
     */
    public function setIdLocal($id_local)
    {
        $this->id_local = $id_local;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getInsertdate()
    {
        return $this->insertdate;
    }

    /**
     * @param \DateTime $insertdate
     */
    public function setInsertdate($insertdate)
    {
        $this->insertdate = $insertdate;
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
    public function __construct()
    {
        parent::__construct();
        $this->notifications = new ArrayCollection();
    }




}

