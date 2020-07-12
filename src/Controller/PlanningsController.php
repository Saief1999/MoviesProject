<?php

namespace App\Controller;

use App\Entity\Planning;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlanningsController extends AbstractController
{
    /**
     * @Route("/plannings", name="plannings")
     */
    public function index(EntityManagerInterface $em )
    {

        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $response = $repo->findBy([],["startingDate"=>"DESC"] );
        $secondResponse=[] ;
        $i=0 ;
        foreach ($response as $element)
        { $secondResponse[$i]=date("d-m-Y",strtotime("+7 day",strtotime(date_format($element->getStartingDate(),"Y-m-d"))));
            $i++ ;
        }
       return $this->render('plannings/allplannings.html.twig', [
           'plannings'=> $response,
           'toDates'=>$secondResponse
        ]);
    }
}
