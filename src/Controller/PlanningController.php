<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\MovieGenre;
use App\Entity\MoviePlanning;
use App\Entity\Planning;
use App\Form\PlanningFormType;
use App\Repository\MovieGenreRepository;
use App\Repository\MoviePlanningRepository;
use App\Repository\MovieRepository;
use App\Services\ScheduleShufflerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    /**
     * @Route("/planning/{id}", name="planning")
     */
    public function planning(ScheduleShufflerService $shuffler,Planning $planning=null)
    {
        if ($planning==null) return $this->render("404.html.twig") ;
        else {

            /**
             * The schedule is done with this model :
             * ["Monday"=>[movie1,movie2...],"Tuesday"=>[],....]
             */
            $schedule = array();
            // init the 7 days
            $shuffler->init($schedule,$planning);
            $plannings=$planning->getMoviePlannings() ;
            foreach ($plannings as $el)
            {   $elDay=$el->getStartingTime()->format("Y-m-d");
                $schedule[$elDay][]=$el ;
            }
            $shuffler->shuffle($schedule);
            return $this->render('planning/planning.html.twig', [
                "schedule"=>$schedule,"planning"=>$planning]);
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
     * @Route("/regowner/planning/remove/{id}",name="remove_planning")
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

    /**
     *
     * @Route("regowner/planning/{id}/addmovie",name="movie_add")
     */

    public function addMovie(Request $request ,EntityManagerInterface $em,MovieRepository $repository,MovieGenreRepository $genRepo,ScheduleShufflerService $shuffler,Planning $planning=null)
    {
        if ($planning==null) return $this->render('404.html.twig') ;
        else
        {
            $validation=true ;
            $moviePlanning = New MoviePlanning() ;
            $moviePlanning ->setPlanning($planning) ;
            $data = json_decode($request->getContent(), true);

/*            $startingTime=$request->request->get("_sTime");
            $endingTime=$request->request->get("_eTime") ;
            $day = $request->request->get("_day") ;
            $search=$request->request->get("search") ;
            $plot =$request->request->get("_plot") ;
            $link=$request->request->get("_link") ;
            $imdb=$request->request->get("_link_imdb");
            $genres =$request->request->get("_genres") ;*/

            $startingTime=$data["sTime"] ;
            $endingTime=$data["eTime"] ;
            $day = $data["day"] ;
            $search=$data["search"] ;
            $plot =$data["plot"] ;
            $link=$data["link"] ;
            $imdb=$data["imdb"];
            $genres =$data["genres"] ;
            $arr_genres=preg_split("/ /" ,$genres,-1,PREG_SPLIT_NO_EMPTY) ;
            if (strlen($search)==0 )
            { $validation=false ;}
            else {
                $weekdays = [];
                $first_day = $planning->getStartingDate()->format("Y-m-d");
                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', strtotime($first_day . "+" . $i . " days"));
                    $weekdays[$i] = (new \DateTime($date))->format("l");
                }
                if (in_array($day, $weekdays)) {

                    $date = date('Y-m-d', strtotime($first_day . "+" . array_search($day, $weekdays) . " days"));
                    $startingDate = $date . " " . $startingTime;
                    $endingDate = $date . " " . $endingTime;

                    $moviePlanning->setStartingTime(new \DateTime($startingDate));
                    $moviePlanning->setEndingTime(new \DateTime($endingDate));

                    $movie = $repository->findOneBy(["tmdbLink" => $link]);
                    if ($movie == null) {
                        $movie = new Movie();
                        $movie->setName($search);
                        $movie->setPlot($plot);
                        $movie->setTmdbLink($link);
                        $movie->setImdbLink($imdb);
                        //Save the genres for the movie
                        foreach ($arr_genres as $genre) {
                            $movieGenre = $genRepo->findOneBy(["name" => $genre]);
                            if ($movieGenre == null) {
                                $movieGenre = new MovieGenre();
                                $movieGenre->setName("genre");
                            }
                            $movie->addGenre($movieGenre);
                        }
                    }
                    $moviePlanning->setMovie($movie);
                }
            }

            if ($validation)
            {
                $em->persist($moviePlanning);
                $em->flush();
                $plannings =$planning->getMoviePlannings() ;
                foreach ($plannings as $el)
                {   $elDay=$el->getStartingTime()->format("Y-m-d");
                    $schedule[$elDay][]=$el ;
                }
                $shuffler->shuffle($schedule);
                $position=array_search($moviePlanning,$schedule[$day]);
                $status = "success";
                $message = "New Movie added";
                $id =$repository->findOneBy(["tmdbLink" => $link])->getId() ;
                $code=200 ;
                return $this->json(["status"=>$status,"message"=>$message,"movieId"=>$id,"position"=>$position+1],$code) ;
            }
            else {
                $status = "failure";
                $message = "Form Error";
                $code=400 ;
                return $this->json(["status"=>$status,"message"=>$message],$code) ;
            }
        }

    }

    /**
     *
     * @Route("/regowner/planning/showplot/{id}",name="movie_plot")
     */

    public function fetchPlot(EntityManagerInterface $em ,$id)
    {
            $mplanning = $em->find(MoviePlanning::class, $id);
            if ( $mplanning== null) return $this->render('404.html.twig');
                /*else return new Response('<div class="cd-schedule-modal__event-info"><div>'.$mplanning->getMovie()->getPlot().'</div></div>') ;*/
               return $this->render("planning/movie.html.twig",["plot"=>$mplanning->getMovie()->getPlot(),"imdb"=>$mplanning->getMovie()->getImdbLink()]) ;
    }
}
