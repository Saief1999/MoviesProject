<?php

namespace App\Controller;

use App\Entity\CinemaOwner;
use App\Entity\RegisteredUser;
use App\Form\CinemaOwnerFormType;
use App\Form\RegisteredUserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegUserController extends AbstractController
{
    /**
     * @Route("/reguser/profile", name="reguser_profile")
     */
    public function profile()
    {
        return $this->render('reguser/profile.html.twig', [
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


        $form = $this->createForm(RegisteredUserFormType::class, $registreduser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($registreduser);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('reguser/settings.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
