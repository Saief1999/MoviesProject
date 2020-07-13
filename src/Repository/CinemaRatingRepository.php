<?php
namespace App\Repository;

use App\Entity\Cinema;
use App\Entity\CinemaRating;
use App\Entity\TblComment;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

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
   public function disableAllOldRatings(Cinema $cinema, User $user)
    {    // $name=$tblComment->getCommentSenderName();
        $query = $this->getEntityManager()
            ->createQuery('
                UPDATE App:CinemaRating rr
                SET rr.enabled = 0
                WHERE rr.user = :user
                AND rr.cinema = :cinema
            ')
        ;
        $query->execute([
            'user' =>$user,
            'cinema' => $cinema->getId(),
        ]);
    }

    public function getRatingFromUser(Cinema $cinema, User $user) : ?CinemaRating
    {
        $queryBuilder = $this->createQueryBuilder('rr');
        $queryBuilder->andWhere('rr.user = :user');
        $queryBuilder->andWhere('rr.cinema = :cinema');
        $queryBuilder->andWhere('rr.enabled = 1');
        $queryBuilder->setParameter('user', $user);
        $queryBuilder->setParameter('cinema', $cinema);
/*        $queryBuilder->orderBy('rr.createdAt', 'DESC');*/
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
        $queryBuilder->groupBy('rr, rr.user');
        $queryBuilder->andWhere('rr.enabled = 1');
        return $queryBuilder->getQuery()->getResult();
    }
}