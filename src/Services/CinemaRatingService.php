<?php

namespace App\Services;

use App\Entity\Cinema;
use App\Entity\CinemaRating;
use App\Entity\TblComment;
use App\Entity\User;
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

    public function saveRating(CinemaRating $rating,User $user)
    {
        $this->em->getRepository(CinemaRating::class)->disableAllOldRatings($rating->getCinema(),$user);
        $rating->setEnabled(true) ;
        $this->em->persist($rating);
        $this->em->flush();
    }

    public function getRating(Cinema $cinema,User $user) : ?CinemaRating
    {
        $userRating = $this->em->getRepository(CinemaRating::class)->getRatingFromUser($cinema, $user);
    /*    if (!$userRating) {
            return $this->em->getRepository(CinemaRating::class)->getRatingGlobal($cinema)[0];
        }*/

        return $userRating ?? null;
    }

    public function getRatingFromUser(Cinema $cinema, User $user) : ?CinemaRating
    {
        return $this->em->getRepository(CinemaRating::class)->getRatingFromUser($cinema, $user);
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