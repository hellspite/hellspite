<?php

namespace Hellspite\AnnounceBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    public function getLatest($num = 4){
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->addOrderBy('p.date', 'DESC')
            ->setMaxResults($num)
            ->getQuery();

        return $query->getResult();
    }
}