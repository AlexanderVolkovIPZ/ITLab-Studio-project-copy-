<?php

namespace App\Repository;

use App\Entity\CategoryHW;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryHW>
 *
 * @method CategoryHW|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryHW|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryHW[]    findAll()
 * @method CategoryHW[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryHWRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryHW::class);
    }

//    /**
//     * @return CategoryHW[] Returns an array of CategoryHW objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategoryHW
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
