<?php

namespace App\DataFixtures;

use App\Entity\MovieGenre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MovieGenreFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {

        $genres = [
            "Action",
            "Adventure",
            "Animation",
            "Biography",
            "Comedy",
            "Crime"	,
            "Documentary",
            "Drama",
            "Family",
            "Fantasy",
            "Film Noir",
            "History",
            "Horror",
            "Music",
            "Musical",
            "Mystery",
            "Romance",
            "Sci-Fi",
            "Short Film",
            "Sport",
            "Superhero",
            "Thriller",
            "War",
            "Western"] ;

        foreach( $genres as $genreName)
        {
            $genre = new MovieGenre()  ;
            $genre->setName($genreName) ;
            $manager->persist($genre);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ["genres"] ;
    }
}
