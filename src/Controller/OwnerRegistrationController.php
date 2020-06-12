<?php

namespace App\Controller;

use App\Entity\CinemaOwner;
use App\Entity\RegisteredUser;
use App\Form\CinemaFormType;
use App\Form\CinemaOwnerFormType;
use App\Form\RegisteredUserFormType;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class OwnerRegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/owner/register", name="owner_app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //$user = new User();
        //$form = $this->createForm(RegistrationFormType::class, $user);

        $owner = new CinemaOwner() ;
        $form = $this->createForm(CinemaOwnerFormType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $basicUser=  $owner->getUser() ;
            $basicUser->setRoles(["ROLE_CIN_OWNER"]);
            // encode the plain password
            $password= $form->get('user')->get('plainPassword')->getData() ;
            $owner->getUser()->setPassword(
                $passwordEncoder->encodePassword(
                    $owner->getUser(),$password
                //$form->get('plainPassword')->getData() doesn't work since it's embedded
                )
            );


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($owner);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $owner->getUser(),
                (new TemplatedEmail())
                    ->from(new Address('zanetisaief.noreply@gmail.com', 'web project bot'))
                    ->to($owner->getUser()->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            //return $this->redirectToRoute('home');
            return $this->render('registration/registration-success.html.twig') ;
        }

        return $this->render('cin-owner/register-owner.html.twig', [
            'ownerRegistrationForm' => $form->createView(),
        ]);
    }
}
