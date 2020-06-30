<?php

namespace App\Controller;

use App\Entity\Cinema;
use App\Entity\TblComment;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\MessageAddService;

class CinemasController extends AbstractController
{
    /**
     * @Route("/cinema/{id?0}/", name="cinema")
     */
    public function cinemasinfo(Cinema $cinema = null,MessageAddService $comment)
    {
        return $this->render("cinemas/singlecinema.html.twig",["cinema"=>$cinema]);
    }


    /**
     * @Route("/cinema/{id?0}/fetch", name="cinema_fetch")
     */
    public function cinemafetch(Cinema $cinema = null,MessageAddService $comment)
    {
       $result= $comment->fetchmessage($cinema);

       return new Response($result)  ;

    }


    /**
     * @Route("/cinema/{id?0}/add", name="cinemaadd")
     */
    public function cinemaadd(Cinema $cinema = null,MessageAddService $comment)
    {
       $comment->addmessage($cinema);
       return new Response() ;
    }


    /**
     * @Route("/cinemas", name="cinemas")
     */
    public function listCinemas()
    {
        $session = $this->get('session');
        $repository = $this->getDoctrine()->getRepository(Cinema::class);
        $cinemas = $repository->findAll();
        return $this->render('cinemas/cinemas.html.twig', [
            'cinemas' => $cinemas,
        ]);
    }
}
