<?php

/**
 * Created by PhpStorm.
 * User: Trad Ala
 * Date: 13/02/2017
 * Time: 23:15
 */
namespace LocalBundle\Repository;

class SignalisationAnnoncesRepository extends \Doctrine\ORM\EntityRepository
{
    function findSerieQB($serie){
        $query = $this ->createQueryBuilder('s');
        $query->where("s.serie=:serie")->setParameter('serie',$serie);
        return $query->getQuery()->getResult();
    }

    function DejaSignaler($user,$annonce){
        $query = $this ->getEntityManager()->createQuery('select s from LocalBundle:SignalisationAnnonces s where s.id_user=:id_user and s.id_annonce=:id_annonce')
            ->setParameter('id_user',$user)
            ->setParameter('id_annonce',$annonce);
        return $query->getResult();
    }

}