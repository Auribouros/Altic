<?php

namespace App\Repository;

use App\Entity\TableDeMultiplication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TableDeMultiplication|null find($id, $lockMode = null, $lockVersion = null)
 * @method TableDeMultiplication|null findOneBy(array $criteria, array $orderBy = null)
 * @method TableDeMultiplication[]    findAll()
 * @method TableDeMultiplication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableDeMultiplicationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TableDeMultiplication::class);
    }

    // /**
    //  * @return TableDeMultiplication[] Returns an array of TableDeMultiplication objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TableDeMultiplication
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
