<?php

namespace App\Repository;

use App\Entity\ProducerHW;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProducerHW>
 *
 * @method ProducerHW|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProducerHW|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProducerHW[]    findAll()
 * @method ProducerHW[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProducerHWRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProducerHW::class);
    }

//    /**
//     * @return ProducerHW[] Returns an array of ProducerHW objects
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

//    public function findOneBySomeField($value): ?ProducerHW
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
