<?php

namespace App\DataFixtures;

use App\Entity\MoviePlanning;
use App\Entity\Planning;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MoviePlanningFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {

        $planning=$manager->find(Planning::class,1);
        $mplanning = new MoviePlanning();
        $mplanning->setStartingTime(new \DateTime('28-06-2020')) ;
        $mplanning->setEndingTime(new \DateTime('28-07-2020'));
        $manager->flush();

    }
/*
 *
 * UNFINISHED
 */
    public static function getGroups(): array
    {
     return ["planning"] ;
    }
}
