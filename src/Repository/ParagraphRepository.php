<?php

namespace App\Repository;

use App\Entity\Chapter;
use App\Entity\Paragraph;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Paragraph|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paragraph|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paragraph[]    findAll()
 * @method Paragraph[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParagraphRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paragraph::class);
    }

     /**
      * @return Paragraph[] Returns an array of Paragraph objects
      */
    public function findByChapter(Chapter $chapter)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.scene = :chapter')
            ->setParameter('chapter', $chapter->getScene())
            ->andWhere('p.section = :section')
            ->setParameter('section', $chapter->getSection())
            ->andWhere('p.work = :work')
            ->setParameter('work', $chapter->getWork())
            // ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Paragraph
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
