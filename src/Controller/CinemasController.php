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
    public function cinemasinfo(Cinema $cinema = null, MessageAddService $comment, Request $request)
    {
        if (isset($cinema)) {

            $repository = $this->getDoctrine()->getRepository(CinemaRating::class);
            $userName = $this->getUser();
           if(isset($userName)) {
               $rating = $repository->findOneBy(array('name' => $userName));

               if (isset($rating)) {
                   return $this->render("cinemas/singlecinema.html.twig", ["cinema" => $cinema, 'YourRating' => $rating]);

               } else {

                   $rating = new CinemaRating();
                   $form = $this->createForm(MyCinemaRatingFormType::class, $rating);
                   return $this->render("cinemas/singlecinema.html.twig", ["cinema" => $cinema, 'Ratingform' => $form->createView()]);
               }
           }
        }
    }


    /**
     * @Route("/cinema/{id?0}/fetch", name="cinema_fetch")
     */
    public function cinemafetch(Cinema $cinema = null, MessageAddService $comment)
    {
        $result = $comment->fetchmessage($cinema);

        return new Response($result);

    }


    /**
     * @Route("/cinema/{id?0}/add", name="cinemaadd")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function cinemaadd(Cinema $cinema = null, MessageAddService $comment, CinemaRatingService $cinemaRatingService, Request $request)
    {
        $comment->addmessage($cinema);
        $session = $this->get('session');
        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(TblComment::class);
        $tblComment = $repository->findOneBy(array('comment_sender_name' => $user));
        $rating = new CinemaRating();
        $form = $this->createForm(MyCinemaRatingFormType::class, $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rating->setName($tblComment->getCommentSenderName());
            $cinemaRatingService->saveRating($rating, $tblComment);

            return new Response();
        }
        return $this->redirectToRoute('cinema');


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
