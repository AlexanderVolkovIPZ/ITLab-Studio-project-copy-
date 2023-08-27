<?php

namespace App\Repository;

use App\Entity\ContentOrderHW;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContentOrderHW>
 *
 * @method ContentOrderHW|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentOrderHW|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentOrderHW[]    findAll()
 * @method ContentOrderHW[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentOrderHWRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentOrderHW::class);
    }

//    /**
//     * @return ContentOrderHW[] Returns an array of ContentOrderHW objects
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

//    public function findOneBySomeField($value): ?ContentOrderHW
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
