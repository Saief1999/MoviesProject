<?php

namespace App\Controller;

use App\Form\ContactUsFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactUsController extends AbstractController
{
    /**
     * @Route("/contactus", name="contact_us")
     */
    public function index(Request $request , MailerInterface $mailer)
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
            $name = $form ->get('name')->getData() ;
            $email = $form->get('email')->getData() ;
            $message = $form->get('message')->getData() ;
            $mail = (new TemplatedEmail())
                ->from(new Address('zanetisaief.noreply@gmail.com', 'Email Sender Bot'))
                ->to('zanetisaief@gmail.com') //link for email account for admin
                ->subject('a User Tried To Contact You ! ')
                ->htmlTemplate('contact_us/contactMail.html.twig')
                ->context(["senderName"=>$name,"senderEmail"=>$email,"senderMessage"=>$message]) ;

            try {
                $mailer->send($mail);
                $this->addFlash("success","Message Sent Successfully");
            } catch (TransportExceptionInterface $e) {
                $this->addFlash("error","Error while Sending message , Try again");
            } finally {
            return $this->render('contact_us/contact_us.twig',['form'=>$form->createView()])  ;
            }
        }
        return $this->render('contact_us/contact_us.twig',['form'=>$form->createView()])  ;
    }
}
