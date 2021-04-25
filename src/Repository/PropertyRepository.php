<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\FilterProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }


    /**
     * @return Property[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param FilterProperty
     * @return Query
     */
    public function  findAllVisibleQuery(FilterProperty $filterproperty)
    {
        $query = $this->findVisibleQuery();

        if($filterproperty->getPriceMax()){
            $query = $query->andwhere('p.price <= :ppriceMax')
                    ->setParameter('ppriceMax', $filterproperty->getPriceMax());
        }

        if($filterproperty->getSurfaceMin()){
            $query = $query->andwhere('p.surface >= :psurfaceMin')
                    ->setParameter('psurfaceMin', $filterproperty->getSurfaceMin());
        }

        if($filterproperty->getRoomsMin()){
            $query = $query->andwhere('p.rooms >= :proomsMin')
                    ->setParameter('proomsMin', $filterproperty->getRoomsMin());
        }

        if($filterproperty->getOptions()->count() > 0){
            $k = 0;
            foreach($filterproperty->getOptions() as $v){   
                $k++;
                $query = $query->andwhere(":poption$k MEMBER of p.options")
                        ->setParameter("poption$k", $v);
            }
        }
       
        return $query->getQuery();
    }

    // public function  findAllVisibleQuery()
    // {
    //     return $this->findVisibleQuery()
    //         ->getQuery();
    // }
    private function findVisibleQuery()
    {   
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }

    //  /**
    //  * @return Property
    //  */
    // public function find($id):Property
    // {
    //     return $this->findVisibleQuery()
    //         ->andWhere('p.id := val')
    //         ->setParameter('val', $id)
    //         ->getQuery()
    //         ->getResult();
    // }
  
    // /**
    //  * @return Property[] Returns an array of Property objects
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
    public function findOneBySomeField($value): ?Property
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
