<?php

namespace App\Controller;

use App\Entity\CinemaOwner;
use App\Entity\RegisteredUser;
use App\Form\CinemaOwnerFormType;
use App\Form\NewPasswordType;
use App\Form\RegisteredUserFormType;
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
        return $this->render('reguser/settings-pages/general.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/reguser/settings/newpassword",name="reguser_newpassword")
     */

    public function changePassword(Request $request , PasswordChanger $passwordChanger)
    {
        $form = $this->createForm(NewPasswordType::class) ;
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordChanger->changePassword($this->getUser(),$form->get('newPass')->getData());
            $this->addFlash("successs",'Password Changed Succefully');
        }
        return $this->render('reguser/settings-pages/newPassword.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
