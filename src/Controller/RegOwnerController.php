<?php

namespace App\Controller;

use App\Entity\CinemaOwner;
use App\Form\CinemaOwnerFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class RegOwnerController extends AbstractController
{
    /**
     * @Route("/regowner/profile", name="regowner_profile")
     */
    public function profile()
    {
        return $this->render('reg_owner/profile.html.twig');
    }
    /**
     * @Route("/regowner/settings",name="regowner_settings")
     */
    public function settings(Request $request, CinemaOwner $cinemaOwner = null) {

        $form = $this->createForm(CinemaOwnerFormType::class, $cinemaOwner);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form['image']) {
                $image = $form['image']->getData();
                $imagePath = md5(uniqid()).$image->getClientOriginalName();
                $destination = __DIR__.'/../../public/assets/uploads';
                try {
                    $image->move($destination,$imagePath);
                    $cinemaOwner->setCinema()->setImagePath('assets/uploads/'.$imagePath);
                } catch (FileException $fe) {
                    echo $fe;
                }
            }
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
