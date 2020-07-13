<?php

namespace App\Controller;

use App\Entity\Cinema;
use App\Entity\CinemaRating;
use App\Entity\TblComment;
use App\Form\MyCinemaRatingFormType;
use Brokoskokoli\StarRatingBundle\Form\RatingType;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\MessageAddService;
use App\Services\CinemaRatingService;


class CinemasController extends AbstractController
{
    /**
     * @Route("/cinema/{id?0}/", name="cinema")
     * @param Cinema|null $cinema
     * @param MessageAddService $comment
     * @param Request $request
     * @return Response
     */
    public function cinemasinfo( MessageAddService $comment,CinemaRatingService $ratingService , Request $request,Cinema $cinema = null)
    {
        if (isset($cinema)) {
            $repository = $this->getDoctrine()->getRepository(CinemaRating::class);
            $user = $this->getUser();
            $cinemaRating = [$ratingService->getRatingGlobal($cinema)??0,ceil($ratingService->getRatingGlobal($cinema))??0] ;
           if(isset($user)) {
               $rating = $repository->findOneBy(array('cinema' => $cinema ,'user'=>$user));
               if (isset($rating)) {
                   return $this->render("cinemas/singlecinema.html.twig", ["cinema" => $cinema, 'ratingisDone' => true,"ratingGlobal"=>$cinemaRating]);

               } else {
                   $rating = new CinemaRating();
                   $form = $this->createForm(MyCinemaRatingFormType::class, $rating);
                   return $this->render("cinemas/singlecinema.html.twig", ["cinema" => $cinema,'ratingisDone' => false ,
                                    'Ratingform' => $form->createView(),"ratingGlobal"=>$cinemaRating]);
               }
           }
           else return $this->render("cinemas/singlecinema.html.twig",["cinema"=>$cinema,"ratingGlobal"=>$cinemaRating]) ;
        }
        else {

            return $this->render("404.html.twig") ;
        }
    }


    /**
     * @Route("/cinema/{id?0}/fetch", name="cinema_fetch")
     */
    public function cinemafetch( MessageAddService $comment,Cinema $cinema = null)
    {
        $result = $comment->fetchmessage($cinema);
        return new Response($result);
    }

    /**
     * @Route("/cinema/{id?0}/add", name="cinemaadd")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function cinemaadd( MessageAddService $comment, CinemaRatingService $cinemaRatingService, Request $request,Cinema $cinema = null)
    {
        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(TblComment::class);
/*        $tblComment = $repository->findOneBy(array('user' => $user));*/
        $rating = new CinemaRating();
        $rating ->setCinema($cinema) ;
        $form = $this->createForm(MyCinemaRatingFormType::class, $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $rating->setUser($user);
            $cinemaRatingService->saveRating($rating, $user);
            $response=$comment->addmessage($cinema,$user);
            $result = $comment->fetchmessage($cinema) ;
        return new Response($result);
        }
    }
    /**
     * @Route("/cinemas", name="cinemas")
     */
    public function listCinemas()
    {
        $repository = $this->getDoctrine()->getRepository(Cinema::class);
        $cinemas = $repository->findAll();
        return $this->render('cinemas/cinemas.html.twig', [
            'cinemas' => $cinemas,
        ]);
    }
}
