<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function settings()
    {
        return $this->render('reguser/settings.html.twig', [
        ]);

    }
}
