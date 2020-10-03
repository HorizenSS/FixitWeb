<?php
/**
 * Created by PhpStorm.
 * User: Trad Ala
 * Date: 13/02/2017
 * Time: 22:50
 */

namespace LocalBundle\Entity;
use Doctrine\ORM\Mapping as ORM ;

/**
 *  @ORM\Entity(repositoryClass="LocalBundle\Repository\SignalisationAnnoncesRepository")
 * @ORM\Table(name="signalisation_annonces")
 */

class SignalisationAnnonces
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="LocalBundle\Entity\Annonce")
     * @ORM\JoinColumn(name="id_annonce",referencedColumnName="id",onDelete="CASCADE")
     */
    private $id_annonce;

    /**
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id",onDelete="CASCADE")
     */
    private $id_user;

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
    public function getIdAnnonce()
    {
        return $this->id_annonce;
    }

    /**
     * @param mixed $id_annonce
     */
    public function setIdAnnonce($id_annonce)
    {
        $this->id_annonce = $id_annonce;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }



}