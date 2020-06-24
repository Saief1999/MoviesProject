<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    /**
     * @Route("/movies", name="movies")
     */
    public function index()
    {
        return $this->render('movies/movies.html.twig');
    }
    /**
     * @Route("/movie", name="movie")
     */
    public function moviesinfo()
    {
        return $this->render('movies/singlemovie.html.twig');
    }
}
