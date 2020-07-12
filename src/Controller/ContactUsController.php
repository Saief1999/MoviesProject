<?php

namespace App\Controller;

use App\Form\ContactUsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactUsController extends AbstractController
{
    /**
     * @Route("/contactus", name="contact_us")
     */
    public function index(Request $request)
    {

        $form = $this->createForm(ContactUsFormType::class) ;
        if (($user=$this->getUser()) != null )
        {
            if (in_array("ROLE_REG_USER",$user->getRoles() ) || in_array("ROLE_CIN_OWNER",$user->getRoles() )) ;
            $form->get('name')->setData($user->getFirstName() ." ". $user->getLastName()) ;
            $form->get('email')->setData($user->getEmail()) ;
        }

        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()  )
        {


        }

        return $this->render('contact_us/contact_us.twig',['form'=>$form->createView()]);
    }
}
