<?php

namespace App\Controller;

use App\Entity\CinemaOwner;
use App\Form\CinemaOwnerFormType;
use App\Services\ImageSaverService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class RegOwnerController extends AbstractController
{
    /**
     * @Route("/regowner/profile", name="regowner_profile")
     */
    public function profile(Request $request, CinemaOwner $cinemaOwner = null)
    {    $session = $this->get('session');
        $cinemaOwneruser = $this->getUser();
        $repository =$this->getDoctrine()->getRepository(CinemaOwner::class);
        $cinemaOwner=$repository->findOneBy(array('user'=>$cinemaOwneruser));
        $profileImage='/uploads/cinema/'.$cinemaOwner->getCinema()->getImagePath();
        return $this->render('reg_owner/profile.html.twig', [
            'cinemaowner' => $cinemaOwner,
            'profileImage'=>$profileImage
        ]);
    }
    /**
     * @Route("/regowner/settings",name="regowner_settings")
     */
    public function settings(Request $request, CinemaOwner $cinemaOwner = null,ImageSaverService $saver) {
        $session = $this->get('session');
        $cinemaOwneruser = $this->getUser();
        $repository =$this->getDoctrine()->getRepository(CinemaOwner::class);
        $cinemaOwner=$repository->findOneBy(array('user'=>$cinemaOwneruser));


        $form = $this->createForm(CinemaOwnerFormType::class, $cinemaOwner);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //saves the image under the uploads path ,then sets the path for the object
            $saver->saveImage($cinemaOwner->getCinema(),$form->get('cinema')->get('image')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cinemaOwner);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('reg_owner/settings.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
