<?php

namespace App\Repository;

use App\Entity\GutenbergBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GutenbergBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method GutenbergBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method GutenbergBook[]    findAll()
 * @method GutenbergBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GutenbergBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GutenbergBook::class);
    }

    // /**
    //  * @return GutenbergBook[] Returns an array of GutenbergBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GutenbergBook
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
