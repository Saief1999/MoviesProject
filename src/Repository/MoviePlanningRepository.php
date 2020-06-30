<?php

namespace App\Repository;

use App\Entity\MoviePlanning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MoviePlanning|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoviePlanning|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoviePlanning[]    findAll()
 * @method MoviePlanning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoviePlanningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoviePlanning::class);
    }

    // /**
    //  * @return MoviePlanningFixtures[] Returns an array of MoviePlanningFixtures objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MoviePlanningFixtures
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
