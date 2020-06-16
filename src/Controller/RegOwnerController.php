<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function settings()
    {
        return $this->render('reg_owner/settings.html.twig', [
        ]);

    }
}
