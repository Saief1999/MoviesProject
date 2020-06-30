<?php

namespace App\Repository;

use App\Entity\TblComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TblComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TblComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TblComment[]    findAll()
 * @method TblComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TblCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TblComment::class);
    }

    // /**
    //  * @return TblComment[] Returns an array of TblComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TblComment
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
