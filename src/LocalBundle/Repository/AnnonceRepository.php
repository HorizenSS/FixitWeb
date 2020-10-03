<?php
/**
 * Created by PhpStorm.
 * User: Sweet
 * Date: 08/04/2019
 * Time: 18:59
 */

namespace LocalBundle\Repository;


class AnnonceRepository extends \Doctrine\ORM\EntityRepository
{
    public function TrierAnnoncesExpire($approuve)
    {
        $query = $this->getEntityManager()
            ->createQuery("
        select s  from LocalBundle:Annonce s where s.approuve like :approuve AND s.enddate < CURRENT_DATE () ORDER BY s.enddate")->setParameter('approuve','%'.$approuve.'%');

        return $query->getResult();
    }


    public function findAnnonceDQL($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery(" 
               select v from LocalBundle:Annonce v where v.nom LIKE :nom")
            ->setParameter('nom','%'.$nom.'%');
        return $query->getResult();

    }
    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM LocalBundle:Annonce e
                WHERE e.nom LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

}