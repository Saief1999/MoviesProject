<?php

namespace App\Repository;

use App\Entity\Cinema;
use App\Entity\CinemaRating;
use App\Entity\TblComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CinemaRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method CinemaRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method CinemaRating[]    findAll()
 * @method CinemaRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CinemaRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CinemaRating::class);
    }

    // /**
    //  * @return CinemaRating[] Returns an array of CinemaRating objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CinemaRating
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
   public function disableAllOldRatings(Cinema $cinema, TblComment $tblComment)
    {    // $name=$tblComment->getCommentSenderName();
        $query = $this->getEntityManager()
            ->createQuery('
                UPDATE App:CinemaRating rr
                SET rr.enabled = 0
                WHERE rr.name = :name
                AND rr.cinema = :cinema
            ')
        ;
        $query->execute([
            'name' => $tblComment->getCommentSenderName(),
            'cinema' => $cinema->getId(),
        ]);
    }

    public function getRatingFromUser(Cinema $cinema, TblComment $tblComment) : ?CinemaRating
    {
        $name = $tblComment->getCommentSenderName();
        $queryBuilder = $this->createQueryBuilder('rr');
        $queryBuilder->andWhere('rr.name = :name');
        $queryBuilder->andWhere('rr.cinema = :cinema');
        $queryBuilder->andWhere('rr.enabled = 1');
        $queryBuilder->setParameter('name', $name);
        $queryBuilder->setParameter('cinema', $cinema);
        $queryBuilder->orderBy('rr.createdAt', 'DESC');
        $queryBuilder->setMaxResults(1);


            return $queryBuilder->getQuery()->getOneOrNullResult();

    }

    /**
     * @param Cinema $cinema
     * @return CinemaRating[]|array
     */
    public function getRatingGlobal(Cinema $cinema) : array
    {
        $queryBuilder = $this->createQueryBuilder('rr');
        $queryBuilder->andWhere('rr.cinema = :cinema');
        $queryBuilder->setParameter('cinema', $cinema);
        $queryBuilder->groupBy('rr, rr.name');
        $queryBuilder->andWhere('rr.enabled = 1');

        return $queryBuilder->getQuery()->getResult();
    }
}
