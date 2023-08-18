<?php

namespace App\Repository;

use App\Entity\OrderHW;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderHW>
 *
 * @method OrderHW|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderHW|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderHW[]    findAll()
 * @method OrderHW[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderHWRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderHW::class);
    }

//    /**
//     * @return OrderHW[] Returns an array of OrderHW objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderHW
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
