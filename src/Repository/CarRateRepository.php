<?php

namespace App\Repository;

use App\Entity\CarRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarRate[]    findAll()
 * @method CarRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarRate::class);
    }

    // /**
    //  * @return CarRate[] Returns an array of CarRate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CarRate
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
