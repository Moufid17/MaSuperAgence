<?php

namespace App\Repository;

use App\Entity\FilterProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FilterProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilterProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilterProperty[]    findAll()
 * @method FilterProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilterPropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilterProperty::class);
    }

    // /**
    //  * @return FilterProperty[] Returns an array of FilterProperty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FilterProperty
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
