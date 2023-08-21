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
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductHW::class);
    }

    /**
     * @param int $itemsPerPage
     * @param int $page
     * @param int $productCount
     * @param int $productPrice
     * @param string|null $productName
     * @param string|null $productImgName
     * @param string|null $categoryName
     * @param string|null $categoryImgName
     * @param string|null $categoryDescription
     * @return float|int|mixed|string
     */
    public function getAllProductByNames(int     $itemsPerPage, int $page, int $productCount, int $productPrice, ?string $productName = null,
                                         ?string $productImgName = null, ?string $categoryName = null, ?string $categoryImgName = null, ?string $categoryDescription = null)
    {
        return $this->createQueryBuilder('product')
            ->join("product.category", "category")
            ->andWhere("product.name LIKE :productName")
            ->andWhere("product.imgName LIKE :productImgName")
            ->andWhere("category.name LIKE :categoryName")
            ->andWhere("category.imgName LIKE :categoryImgName")
            ->andWhere("category.description LIKE :categoryDescription")
            ->andWhere("product.count = :productCount")
            ->andWhere("product.price = :productPrice")
            ->setParameter("productName", "%" . $productName . "%")
            ->setParameter("productImgName", "%" . $productImgName . "%")
            ->setParameter("categoryName", "%" . $categoryName . "%")
            ->setParameter("categoryImgName", "%" . $categoryImgName . "%")
            ->setParameter("categoryDescription", "%" . $categoryDescription . "%")
            ->setParameter("productCount", $productCount)
            ->setParameter("productPrice", $productPrice)
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage)
            ->orderBy("product.name", "DESC")
            ->getQuery()
            ->getResult();
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
