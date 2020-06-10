<?php

namespace App\Repository;

use App\Entity\RegisteredUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RegisteredUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegisteredUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegisteredUser[]    findAll()
 * @method RegisteredUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegisteredUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegisteredUser::class);
    }

    // /**
    //  * @return RegisteredUser[] Returns an array of RegisteredUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegisteredUser
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
