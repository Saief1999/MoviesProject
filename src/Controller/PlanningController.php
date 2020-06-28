<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\PlanningFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    /**
     * @Route("/regowner/plannings/{id}", name="planning")
     */
    public function planning(Planning $planning=null)
    {
        if ($planning==null) return $this->render("404.html.twig") ;
        else {

            return $this->render('planning/planning.html.twig', [
                'controller_name' => 'PlanningController',
            ]);
        }

    }

    /**
     * @Route("/regowner/plannings",name="myplannings")
     */
    public function plannings(\Symfony\Component\HttpFoundation\Request $request)
    {
        $pageActuelle = $request->query->get('page')??1;
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $response = $repo->findBy([], ["id"=>"DESC"], 10, ($pageActuelle==1) ?0: ($pageActuelle)* 10-1 );
        $secondResponse =[] ;
        $i=0 ;
        foreach ($response as $element)
        {
            $secondResponse[$i]=date("d-m-Y",strtotime("+7 day",strtotime(date_format($element->getStartingDate(),"Y-m-d"))));
            $i++ ;
        }

        $nbPages = ceil(($repo->count([])) / 10);
        return $this->render("planning/plannings.html.twig", ['t' => $response,'t2'=>$secondResponse, 'nbpages' => $nbPages]);
    }

    /**
     * @Route("/regowner/plannings/add",name="add_planning")
     */
    public function addPlanning(EntityManagerInterface $em,\Symfony\Component\HttpFoundation\Request $request)
    {
        $planning =new Planning() ;
        $form=$this->createForm(PlanningFormType::class,$planning);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
                $em->persist($planning);
                $em->flush() ;
                $this->addFlash("success","Planning Added Successfully");

            return $this->redirectToRoute("myplannings",['p'=>1]);
        }
        else return $this->render("planning/add_planning.html.twig",["form"=>$form->createView()]) ;

    }

    /**
     * @Route("/regowner/plannings/remove/{id}",name="remove_planning")
     */
    public function removePlanning(EntityManagerInterface $em ,Planning $planning=null)
    {
        if ($planning==null) return $this->render('404.html.twig') ;
        else
        {
            $em ->remove($planning) ;
            $em->flush();
            $this->addFlash('success',"Planning deleted successfully");
            return $this->redirectToRoute("myplannings",['p'=>1]);
        }
    }
}
