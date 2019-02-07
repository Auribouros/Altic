<?php

namespace App\Repository;

use App\Entity\PersonnageJouable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PersonnageJouable|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonnageJouable|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonnageJouable[]    findAll()
 * @method PersonnageJouable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnageJouableRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PersonnageJouable::class);
    }

    // /**
    //  * @return PersonnageJouable[] Returns an array of PersonnageJouable objects
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
    public function findOneBySomeField($value): ?PersonnageJouable
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
