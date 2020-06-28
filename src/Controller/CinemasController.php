<?php

namespace App\Controller;

use App\Entity\Cinema;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CinemasController extends AbstractController
{
    /**
     * @Route("/cinemas", name="cinemas")
     */
    public function index()
    {
        return $this->render('cinemas/cinemas.html.twig', [
            'controller_name' => 'CinemasController',
        ]);
    }
    /**
    * @Route("/cinema/{id?0}", name="cinema")
    */
    public function cinemasinfo(Cinema $cinema = null)
    {
        if ($cinema==null)
            return $this->render('cinemanotfound.html.twig');
        return $this->render('cinemas/singlecinema.html.twig', ['cinema' => $cinema]);
    }

    /**
     * @Route("/cinemas", name="cinemas")
     */
    public function listCinemas()
    { $session = $this->get('session');
        $repository =$this->getDoctrine()->getRepository(Cinema::class);
        $cinemas=$repository->findAll();
        return $this->render('cinemas/cinemas.html.twig', [
            'cinemas' => $cinemas,
        ]);
    }
}
