<?php

namespace App\Repository;

use App\Entity\PNJ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PNJ|null find($id, $lockMode = null, $lockVersion = null)
 * @method PNJ|null findOneBy(array $criteria, array $orderBy = null)
 * @method PNJ[]    findAll()
 * @method PNJ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PNJRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PNJ::class);
    }

    // /**
    //  * @return PNJ[] Returns an array of PNJ objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PNJ
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
