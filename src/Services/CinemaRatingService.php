<?php

namespace App\Services;

use App\Entity\Cinema;
use App\Entity\CinemaRating;
use App\Entity\TblComment;
use Doctrine\ORM\EntityManagerInterface;


class CinemaRatingService
{
    private $em;



    /**
     * UserService constructor.
     * @param EntityManagerInterface $entityManager

     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->em = $entityManager;

    }

    public function saveRating(CinemaRating $rating,TblComment $tblComment)
    {
        $this->em->getRepository(CinemaRating::class)->disableAllOldRatings($rating->getCinema(),$tblComment);
        $this->em->persist($rating);
        $this->em->flush();
    }

    public function getRating(Cinema $cinema,TblComment $comment) : ?CinemaRating
    {
        $userRating = $this->em->getRepository(CinemaRating::class)->getRatingFromUser($cinema, $comment);
        if (!$userRating) {
            return $this->em->getRepository(CinemaRating::class)->getRatingGlobal($cinema);
        }

        return $userRating;
    }

    public function getRatingFromUser(Cinema $cinema, TblComment $comment) : ?CinemaRating
    {
        return $this->em->getRepository(CinemaRating::class)->getRatingFromUser($cinema, $comment);
    }

    public function getRatingGlobal(Cinema $cinema)
    {
        $list = $this->em->getRepository(CinemaRating::class)->getRatingGlobal($cinema);

        if (count($list) == 0) {
            return null;
        }

        $sum = 0;
        $count = 0;
        foreach ($list as $rating) {
            if ($rating->getEnabled()) {
                $sum += $rating->getRating();
                $count++;
            }
        }

        return floatval($sum)/floatval($count);
    }
}