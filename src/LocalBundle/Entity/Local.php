<?php

namespace LocalBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Local
 *
 * @ORM\Table(name="local", indexes={@ORM\Index(name="prop", columns={"prop"}), @ORM\Index(name="prop_2", columns={"prop"}), @ORM\Index(name="prop_3", columns={"prop"}), @ORM\Index(name="prop_4", columns={"prop"})})
 * @ORM\Entity
 */
class Local
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_local", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idLocal;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    public $description;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nom_local", type="string", length=50, nullable=false)
     */
    public $nomLocal;

    /**
     * @var float
     * @Assert\NotBlank()
     * @Assert\Range(
     * min = 10,
     * max = 1000000,
     *  minMessage = "superficie doit avoir aux moins{{ limit }} m de longueur",
     *  maxMessage = " nsuperficie doit avoir aux plus{{ limit }} m de longueur")
     * @ORM\Column(name="superficie", type="float", precision=10, scale=0, nullable=false)
     */
    public $superficie;

    /**
     * @var string
     * @ORM\Column(name="localisation", type="string", length=20, nullable=false)
     */
    public $localisation;

    /**
     * Many Features have One Modele.
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\User")
     * @ORM\JoinColumn(name="prop", referencedColumnName="id")
     */
    private $prop;

    /**
     * @return mixed
     */
    public function getProp()
    {
        return $this->prop;
    }

    /**
     * @param mixed $prop
     */
    public function setProp($prop)
    {
        $this->prop = $prop;
    }







    /**
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
    public function getNomLocal()
    {
        return $this->nomLocal;
    }

    /**
     * @param string $nomLocal
     */
    public function setNomLocal($nomLocal)
    {
        $this->nomLocal = $nomLocal;
    }

    /**
     * @return float
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * @param float $superficie
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;
    }

    /**
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param string $localisation
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;
    }

    /**
     * @return int
     */
    public function getIdLocal()
    {
        return $this->idLocal;
    }

    /**
     * @param int $idLocal
     */
    public function setIdLocal($idLocal)
    {
        $this->idLocal = $idLocal;
    }



    function __toString()
    {
        return (string) $this->nomLocal;
    }
}

