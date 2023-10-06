<?php

namespace App\Repository;

use App\Entity\BedCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BedCategory>
 *
 * @method BedCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BedCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BedCategory[]    findAll()
 * @method BedCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BedCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BedCategory::class);
    }

//    /**
//     * @return BedCategory[] Returns an array of BedCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BedCategory
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
