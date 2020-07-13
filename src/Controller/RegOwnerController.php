<?php

namespace App\Controller;

use App\Entity\CinemaOwner;
use App\Form\ChangeEmailFormType;
use App\Form\CinemaFormType;
use App\Form\CinemaOwnerFormType;
use App\Form\NewPasswordFormType;
use App\Services\CinemaRatingService;
use App\Services\EmailChanger;
use App\Services\ImageSaverService;
use App\Services\PasswordChanger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class RegOwnerController extends AbstractController
{
    /**
     * @Route("/regowner/profile", name="regowner_profile")
     */
    public function profile(Request $request, CinemaOwner $cinemaOwner = null,CinemaRatingService $ratingService)
    {    $session = $this->get('session');
        $cinemaOwneruser = $this->getUser();
        $repository =$this->getDoctrine()->getRepository(CinemaOwner::class);
        $cinemaOwner=$repository->findOneBy(array('user'=>$cinemaOwneruser));
        $profileImage='/uploads/cinema/'.$cinemaOwner->getCinema()->getImagePath();
        $rating =$ratingService->getRatingGlobal($cinemaOwner->getCinema()) ;
        return $this->render('reg_owner/profile.html.twig', [
            'cinemaowner' => $cinemaOwner,
            'profileImage'=>$profileImage ,
            'rating' =>$rating??0
        ]);
    }
    /**
     * @Route("/regowner/settings",name="regowner_settings")
     */
    public function settings(Request $request, CinemaOwner $cinemaOwner = null,ImageSaverService $saver) {
        $cinemaOwneruser = $this->getUser();
        $repository =$this->getDoctrine()->getRepository(CinemaOwner::class);
        $cinemaOwner=$repository->findOneBy(array('user'=>$cinemaOwneruser));


        $form = $this->createForm(CinemaOwnerFormType::class, $cinemaOwner)
            ->remove('cinema') ;
            $form->get('user')
                ->remove('agreeTerms')
                ->remove('plainPassword')
                ->remove('email')
                ->remove('username') ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //saves the image under the uploads path ,then sets the path for the object
            $saver->saveImage($cinemaOwner->getCinema(),$form->get('cinema')->get('image')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cinemaOwner);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('reg_owner/settings_pages/general.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/regowner/settings/newpassword",name="regowner_newpassword")
     */

    public function changePassword(Request $request , PasswordChanger $passwordChanger)
    {
        $form = $this->createForm(NewPasswordFormType::class) ;
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordChanger->changePassword($this->getUser(),$form->get('newPass')->getData());
            $this->addFlash("success",'Password Changed Succefully');
        }
        return $this->render('reg_owner/settings_pages/newPassword.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/regowner/settings/newemail",name="regowner_newemail")
     */
    public function changeEmail(Request $request,EmailChanger $emailChanger)
    {
        $form = $this->createForm(ChangeEmailFormType::class) ;
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $emailChanger->changeEmail($this->getUser(),$form->get('newEmail')->getData());
            $this->addFlash("success",'Email Changed Succefully');
        }
        return $this->render('reg_owner/settings_pages/newEmail.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/regowner/settings/yourcinema",name="regowner_cinema")
     */

    public function editCinema(Request $req , EntityManagerInterface $em,ImageSaverService $saver)
    {   $cinemaOwneruser = $this->getUser();
        $repository =$this->getDoctrine()->getRepository(CinemaOwner::class);
        $owner=$repository->findOneBy(array('user'=>$cinemaOwneruser));
        $cinemaOwner=$em->getRepository(CinemaOwner::class)
                    ->findOneBy(array('user'=>$this->getUser()));
        $cinema = $cinemaOwner->getCinema() ;
        $form = $this->createForm(CinemaFormType::class,$cinema) ;
        $form->handleRequest($req) ;

        if ($form->isSubmitted() && $form ->isValid())
        {
            $saver->saveImage($owner->getCinema(),$form->get('image')->getData());
            $em->persist($cinema);
            $em->flush() ;
            $this->addFlash("success",'Cinema Informations Changed Succefully');
        }
        return $this->render("reg_owner/settings_pages/cinema.html.twig",["form"=>$form->createView(),"imgPath"=>$cinema->getImagePath()]) ;
    }
}
