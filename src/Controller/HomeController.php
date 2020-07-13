<?php

namespace App\Controller;

use App\Entity\Cinema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repo =$this->getDoctrine()->getRepository(Cinema::class) ;
        $colisee = $repo->findOneBy(["id"=>9])  ;
        $pathe = $repo->findOneBy(["id"=>8]);
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'colisee'=>$colisee ,
            'pathe' => $pathe
        ]);
    }
}
