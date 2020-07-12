<?php

namespace App\Controller;

use App\Entity\CinemaOwner;
use App\Entity\RegisteredUser;
use App\Form\ChangeEmailFormType;
use App\Form\CinemaOwnerFormType;
use App\Form\NewPasswordFormType;
use App\Form\RegisteredUserFormType;
use App\Services\EmailChanger;
use App\Services\PasswordChanger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegUserController extends AbstractController
{
    /**
     * @Route("/reguser/profile", name="reguser_profile")
     */
    public function profile(RegisteredUser $registereduser = null)
    { $session = $this->get('session');
        $user = $this->getUser();
        $repository =$this->getDoctrine()->getRepository(RegisteredUser::class);
        $registereduser=$repository->findOneBy(array('user'=>$user));
        return $this->render('reguser/profile.html.twig', [
            'registereduser' => $registereduser,
        ]);
    }

    /**
     * @Route("/reguser/settings",name="reguser_settings")
     */
    public function settings(Request $request,  RegisteredUser $registreduser=null) {
        $session = $this->get('session');
        $user = $this->getUser();
        $repository =$this->getDoctrine()->getRepository(RegisteredUser::class);
        $registreduser=$repository->findOneBy(array('user'=>$user));


        $form = $this->createForm(RegisteredUserFormType::class, $registreduser) ;
        $form->get('user')
            ->remove('agreeTerms')
            ->remove('plainPassword')
            ->remove('email')
            ->remove('username') ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($registreduser);
            $entityManager->flush();
            $this->addFlash("success","profile Changed Successfully");
        }
        return $this->render('reguser/settings_pages/general.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/reguser/settings/newpassword",name="reguser_newpassword")
     */

    public function changePassword(Request $request , PasswordChanger $passwordChanger)
    {
        $form = $this->createForm(NewPasswordFormType::class) ;
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordChanger->changePassword($this->getUser(),$form->get('newPass')->getData());
            $this->addFlash("success",'Password Changed Succefully');
        }
        return $this->render('reguser/settings_pages/newPassword.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/reguser/settings/newemail",name="reguser_newemail")
     */
    public function changeEmail(Request $request,EmailChanger $emailChanger)
    {
        $form = $this->createForm(ChangeEmailFormType::class) ;
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $isValid=$emailChanger->changeEmail($this->getUser(),$form->get('newEmail')->getData());

            $t=preg_split('/-/',$isValid,-1) ;
                $this->addFlash($t[0],$t[1]);
        }
        return $this->render('reguser/settings_pages/newEmail.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
