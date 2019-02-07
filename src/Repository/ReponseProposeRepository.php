<?php

namespace App\Repository;

use App\Entity\ReponsePropose;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReponsePropose|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponsePropose|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponsePropose[]    findAll()
 * @method ReponsePropose[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseProposeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReponsePropose::class);
    }

    // /**
    //  * @return ReponsePropose[] Returns an array of ReponsePropose objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReponsePropose
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
