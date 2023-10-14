<?php

namespace App\Repository;

use App\Entity\Invoice;
use App\Entity\Product;
use App\Entity\ProductInvoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductInvoice>
 *
 * @method ProductInvoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductInvoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductInvoice[]    findAll()
 * @method ProductInvoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductInvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductInvoice::class);
    }

//    /**
//     * @return ProductInvoice[] Returns an array of ProductInvoice objects
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

//    public function findOneBySomeField($value): ?ProductInvoice
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findAllOccurrencesByProduct(?int $limit = null)
    {
        $query = $this->createQueryBuilder('p')
            ->leftJoin('p.product', 'pr')
            ->addSelect('pr')
            ->select('pr.id, p, COUNT(p.product) AS number')
            ->groupBy('p.product');
            if($limit){
                $query->setMaxResults($limit);
            };
        return $query->getQuery()
            ->getResult();
    }

    public function findAllByProduct(Product $product, ?int $limit = null)
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.product = :pr')
            ->setParameter('pr', $product)
            ->groupBy('p.color');

            if($limit){
                $query->setMaxResults($limit);
            };
        return $query->getQuery()
            ->getResult();
    }
    public function findAllByProductAndColor(Product $product, string $color, ?int $limit = null)
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.product = :pr')
            ->setParameter('pr', $product)
            ->andWhere('p.color = :color')
            ->setParameter('color', $color)
            ->select('p.size, SUM(p.quantity) AS number')
            ->groupBy('p.size');

            if($limit){
                $query->setMaxResults($limit);
            };
        return $query->getQuery()
            ->getResult();
    }
}
