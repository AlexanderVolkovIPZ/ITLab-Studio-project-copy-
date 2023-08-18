<?php

namespace App\Repository;

use App\Entity\CustomerHW;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerHW>
 *
 * @method CustomerHW|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerHW|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerHW[]    findAll()
 * @method CustomerHW[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerHWRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerHW::class);
    }

//    /**
//     * @return CustomerHW[] Returns an array of CustomerHW objects
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

//    public function findOneBySomeField($value): ?CustomerHW
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
