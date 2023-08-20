<?php

namespace App\Repository;

use App\Entity\ProductHW;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductHW>
 *
 * @method ProductHW|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductHW|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductHW[]    findAll()
 * @method ProductHW[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductHWRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductHW::class);
    }

//    /**
//     * @return ProductHW[] Returns an array of ProductHW objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductHW
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}